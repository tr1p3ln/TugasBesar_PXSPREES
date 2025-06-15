<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\UserVoucher;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    //menampilkan semau data booking untuk admin
    public function view(Request $request)
    {
        // Query dasar untuk mengambil booking
        $query = Booking::with(['user', 'room', 'payment'])->latest();

        // Terapkan filter tanggal jika ada
        if ($request->filled('filter_status')) {
            $query->where('status', $request->filter_status);
        }
        
        if ($request->filled('filter_date')) {
            $query->whereDate('start_time', $request->filter_date);
        }

        $bookings = $query->get();

        $bookings = $query->get();

        return view('admin.bookingdata', compact('bookings'));
    }

    // Menampilkan form booking (sudah ada di view Anda)
    public function create()
    {
        return view('user.booking'); // Sesuaikan dengan nama view
    }



    // Cek ketersediaan room
    private function isRoomAvailable($roomId, $startTime, $duration)
    {
        // Pastikan $startTime adalah objek Carbon
        if (!$startTime instanceof Carbon) {
            $startTime = Carbon::parse($startTime);
        }
        $endTime = $startTime->copy()->addHours($duration);

        // Query yang dimodifikasi untuk menghindari error dengan DATE_ADD di whereBetween
        // Kita akan cek booking yang start_time-nya berada di antara rentang waktu yang diinginkan
        // ATAU booking yang end_time-nya (start_time + duration_hour) berada di antara rentang waktu yang diinginkan
        // ATAU booking yang mencakup seluruh rentang waktu yang diinginkan

        $conflictingBooking = Booking::where('room_id', $roomId)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where(function ($q) use ($startTime, $endTime) {
                    // Booking mulai di dalam rentang waktu yang diminta
                    $q->where('start_time', '>=', $startTime)
                        ->where('start_time', '<', $endTime);
                })->orWhere(function ($q) use ($startTime, $endTime) {
                    // Booking berakhir di dalam rentang waktu yang diminta
                    // Kita perlu menghitung end_time booking yang ada di DB
                    // Ini bisa jadi rumit jika duration_hour bervariasi banyak.
                    // Cara lebih sederhana: Cek jika rentang yang diminta overlap dengan booking yang ada.
                    // A booking (B_start, B_end) overlaps with requested (R_start, R_end) if:
                    // (B_start < R_end) AND (B_end > R_start)
                    $q->where('start_time', '<', $endTime) // Booking dimulai sebelum waktu akhir yang diminta
                        ->where(DB::raw("TIMESTAMPADD(HOUR, duration_hour, start_time)"), '>', $startTime); // Booking berakhir setelah waktu mulai yang diminta
                });
            })->exists();

        return !$conflictingBooking;
    }

    // Validasi dan aplikasikan voucher
    // Validasi dan siapkan detail voucher untuk diaplikasikan
    // Tidak langsung update is_used di sini, tapi saat booking disimpan dalam transaksi.
    private function applyAndValidateUserVoucher($voucherCode, $userId, $currentTotalPrice)
    {
        $voucher = Voucher::where('voucher_code', $voucherCode)
            // ->where('is_active', true) // Jika ada kolom is_active di tabel vouchers
            ->where('start_date', '<=', Carbon::today())
            ->where('end_date', '>=', Carbon::today())
            ->first();

        if (!$voucher) {
            return ['error' => 'Kode voucher tidak valid atau sudah kedaluwarsa.'];
        }

        // Cek apakah user punya voucher ini dan belum dipakai
        $userVoucher = UserVoucher::where('user_id', $userId)
            ->where('voucher_id', $voucher->id)
            ->where('is_used', false)
            ->first();

        if (!$userVoucher) {
            return ['error' => 'Anda tidak memiliki voucher ini atau voucher sudah digunakan.'];
        }

        // Jika voucher memerlukan poin dan user tidak cukup poin (jika ada logika ini)
        // if ($voucher->point_required > Auth::user()->current_points) {
        //     return ['error' => 'Poin Anda tidak cukup untuk menggunakan voucher ini.'];
        // }

        // Kalkulasi harga setelah diskon
        $priceAfterDiscount = max(0, $currentTotalPrice - $voucher->discount_amount);

        // Untuk sekarang, fungsi ini hanya mengembalikan informasi
        $userVoucher->is_used = true; // Tandai akan digunakan
        $userVoucher->save(); // Simpan perubahan status voucher


        return [
            'total_price_after_discount' => $priceAfterDiscount,
            'user_voucher_id' => $userVoucher->id,
            'voucher_details' => $voucher // Kirim detail voucher jika perlu
        ];
    }


    // Menyimpan booking baru
    public function store(Request $request)
    {
        // Validasi input 
        $validated = $request->validate([
            'console_type' => 'required|string|in:Playstation,Nintendo,VIP', // Sesuai dengan name di JS
            'booking_date' => 'required|date_format:Y-m-d', // Masih dikirim, bisa untuk double check
            'start_time' => 'required|date_format:Y-m-d H:i:s', // Format dari JS
            'room_id' => 'required|integer|exists:rooms,id',     // Dari <select name="room_id">
            'customer_name' => 'required|string|max:255',       // Dari input customer_name
            'duration_hour' => 'required|integer|min:1',        // Dari JS
            // 'total_price' => 'required|numeric|min:0',       // Dari JS, tapi akan dihitung ulang
            'voucher_code' => 'nullable|string|exists:vouchers,voucher_code' // Validasi voucher_code
        ]);

        // Cari room berdasarkan room_id
        $room = Room::findOrFail($validated['room_id']);

        // Pastikan console_type room sesuai dengan yang dipilih (tambahan keamanan)
        if ($room->console_type !== $validated['console_type']) {
            return response()->json(['message' => 'Tipe konsol ruangan tidak sesuai.'], 422);
            // atau return back()->with('error', 'Tipe konsol ruangan tidak sesuai.'); jika bukan AJAX
        }

        // Waktu booking sudah diformat dari JS
        $startTime = Carbon::parse($validated['start_time']);
        $duration = (int)$validated['duration_hour'];

        // Validasi ketersediaan room (menggunakan method yang sudah ada)
        if (!$this->isRoomAvailable($room->id, $startTime, $duration)) {
            // Jika request datang dari AJAX (seperti fetch di view Anda)
            return response()->json(['message' => 'Ruangan tidak tersedia pada waktu yang dipilih! Harap pilih waktu atau ruangan lain.'], 422);
            // Jika ini adalah fallback non-AJAX form submission (jarang terjadi jika JS aktif)
            // return back()->with('error', 'Ruangan tidak tersedia di waktu yang dipilih!');
        }

        // Hitung ulang total harga di backend
        $totalPrice = $room->price_per_hour * $duration;
        $originalPriceForVoucher = $totalPrice; // Simpan harga asli sebelum diskon voucher

        // Proses voucher jika ada
        $userVoucherId = null;
        $appliedVoucher = null; // Untuk menyimpan detail voucher yang diaplikasikan

        if (!empty($validated['voucher_code'])) {
            $voucherProcessingResult = $this->applyAndValidateUserVoucher(
                $validated['voucher_code'],
                Auth::id(),
                $originalPriceForVoucher // Kirim harga sebelum diskon potensial
            );

            if (isset($voucherProcessingResult['error'])) {
                return response()->json(['message' => $voucherProcessingResult['error']], 422);
            }

            if (isset($voucherProcessingResult['total_price_after_discount'])) {
                $totalPrice = $voucherProcessingResult['total_price_after_discount'];
                $userVoucherId = $voucherProcessingResult['user_voucher_id'];
                // $appliedVoucher = $voucherProcessingResult['voucher_details']; // Jika perlu info voucher
            }
        }


        DB::beginTransaction();
        try {
            // Simpan booking
            $booking = Booking::create([
                'user_id' => Auth::id(),
                'room_id' => $room->id,
                'user_voucher_id' => $userVoucherId,
                'start_time' => $startTime,
                'duration_hour' => $duration,
                'total_price' => $totalPrice,
                'status' => 'pending' // Status awal booking
            ]);

            $payment = new \App\Models\Payment([ // Pastikan namespace model Payment benar
                'booking_id' => $booking->id,
                'amount' => $booking->total_price,
                'payment_status' => 'pending',
                // Anda bisa set payment_method default di sini jika mau
                'payment_method' => 'transfer', // contoh
            ]);
            $payment->save();

            // Jika voucher digunakan, update statusnya di tabel user_vouchers
            // Logika ini sudah ada di applyAndValidateUserVoucher jika Anda memindahkannya
            // Jika tidak, lakukan di sini:
            if ($userVoucherId) {
                $userVoucher = UserVoucher::find($userVoucherId);
                if ($userVoucher && !$userVoucher->is_used) { // double check
                    // userVoucher->is_used = true; // Ini sudah dihandle di applyAndValidate...
                    // userVoucher->save(); // Ini sudah dihandle di applyAndValidate...
                }
            }

            // Anda mungkin ingin mengubah status ruangan menjadi 'Booked' jika logika Anda begitu
            // $room->status = 'Booked';
            // $room->save();
            // Namun, command app:update-room-status mungkin lebih cocok untuk ini,
            // atau status ruangan diubah saat pembayaran 'confirmed'.

            DB::commit();

            // Karena request datang dari fetch API yang mengharapkan JSON
            return response()->json([
                'message' => 'Booking berhasil dibuat dan menunggu pembayaran!',
                'booking_id' => $booking->id // Kirim booking_id agar bisa redirect
            ], 201); // HTTP 201 Created

        } catch (\Exception $e) {
            DB::rollBack();
            // Log errornya ke file log agar tetap tercatat
            \Illuminate\Support\Facades\Log::error($e);

            // Kembalikan pesan error yang asli ke response JSON untuk dilihat di browser
            return response()->json([
                'message' => 'Terjadi kesalahan!', // Pesan umum
                'error' => $e->getMessage(), // Pesan error asli
                'trace' => $e->getTraceAsString() // (Opsional) Jejak error
            ], 500);
        }
    }

    public function checkAvailability(Request $request)
    {
        // Log::info('checkAvailability called with:', $request->all()); // Untuk debug

        $validated = $request->validate([
            'console_type' => 'required|string|in:Playstation,Nintendo,VIP',
            'date' => 'required|date_format:Y-m-d|after_or_equal:today',
        ]);

        $consoleType = $validated['console_type'];
        $bookingDate = $validated['date'];

        // 1. Ambil semua ruangan yang tersedia berdasarkan console_type
        $availableRooms = Room::where('console_type', $consoleType)
            ->whereNotIn('status', ['Disabled', 'Maintenance']) // Sesuaikan status yang tidak diinginkan
            ->select('id', 'name', 'price_per_hour')
            ->get();

        // Log::info('Available rooms found:', $availableRooms->toArray());

        if ($availableRooms->isEmpty()) {
            return response()->json(['rooms' => [], 'booked_slots' => new \stdClass()]);
        }

        $bookedSlotsByRoomId = [];

        foreach ($availableRooms as $room) {
            $bookingsForRoomOnDate = Booking::where('room_id', $room->id)
                ->whereDate('start_time', $bookingDate)
                ->whereIn('status', ['pending', 'confirmed'])
                ->select('start_time', 'duration_hour')
                ->get();

            $roomBookedTimeRanges = [];
            if ($bookingsForRoomOnDate->isNotEmpty()) {
                foreach ($bookingsForRoomOnDate as $booking) {
                    // Pastikan start_time adalah objek Carbon
                    $bookingStartTime = Carbon::parse($booking->start_time);
                    for ($i = 0; $i < $booking->duration_hour; $i++) {
                        $slotStart = $bookingStartTime->copy()->addHours($i)->format('H:i');
                        $slotEnd = $bookingStartTime->copy()->addHours($i + 1)->format('H:i');
                        $roomBookedTimeRanges[] = "{$slotStart}-{$slotEnd}";
                    }
                }
            }
            $bookedSlotsByRoomId[$room->id] = array_unique($roomBookedTimeRanges);
        }
        // Log::info('Booked slots data:', $bookedSlotsByRoomId);

        return response()->json([
            'rooms' => $availableRooms,
            'booked_slots' => $bookedSlotsByRoomId,
        ]);
    }


    public function showPaymentPage(Booking $booking)
    {
        // Keamanan: Pastikan hanya user yang membuat booking yang bisa melihat halaman pembayaran ini
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'UNAUTHORIZED ACTION.');
        }

        $payment = \App\Models\Payment::where('booking_id', $booking->id)->first();
        if (!$payment) {
        return redirect()->route('user.home')->with('error', 'Data pembayaran untuk booking ini tidak ditemukan.');
    }

        // Kirim data booking ke view payment.blade.php
        return view('user.payment', [
        'booking' => $booking,
        'payment' => $payment // Variabel $payment sekarang dikirim
    ]);
    }
    //status booking
    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled'
        ]);

        $booking->update(['status' => $validated['status']]);

        return back()->with('success', 'Status booking berhasil diperbarui.');
    }
}
