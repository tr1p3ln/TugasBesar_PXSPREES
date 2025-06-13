<?php

namespace App\Http\Controllers\Admin;

// Import semua kelas yang dibutuhkan
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Notifications\PaymentConfirmed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Menampilkan halaman daftar pembayaran yang perlu diverifikasi.
     */
    public function index()
    {
        // Ambil semua pembayaran yang statusnya 'pending' beserta data booking dan user terkait.
        // Urutkan dari yang terbaru.
        $payments = Payment::where('payment_status', 'pending')
            ->with('booking.user') // Eager load relasi untuk efisiensi
            ->latest()
            ->get();

        // Tampilkan view dan kirim data payments
        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Mengonfirmasi pembayaran yang dipilih oleh admin.
     */
    public function confirm(Request $request, Payment $payment)
    {
        // Gunakan transaksi database untuk memastikan semua proses berhasil atau semua dibatalkan.
        DB::beginTransaction();

        try {
            // 1. Update status payment menjadi 'paid' dan catat waktu pembayarannya.
            $payment->update([
                'payment_status' => 'paid',
                'paid_at' => now()
            ]);

            // 2. Ambil booking yang terkait dan update statusnya menjadi 'confirmed'.
            $booking = $payment->booking;
            $booking->update(['status' => 'confirmed']);

            // 3. Ambil user pemilik booking tersebut.
            $user = $booking->user;

            // 4. Kirim notifikasi konfirmasi ke user.
            $user->notify(new PaymentConfirmed($booking));

            // Jika semua proses berhasil, simpan perubahan ke database.
            DB::commit();

            // Kembalikan ke halaman sebelumnya dengan pesan sukses.
            return back()->with('success', 'Booking berhasil dikonfirmasi.');
        } catch (\Exception $e) {
            // Jika terjadi error di salah satu proses, batalkan semua perubahan.
            DB::rollBack();

            // (Opsional) Catat error ke log untuk debugging
            \Illuminate\Support\Facades\Log::error('Gagal konfirmasi pembayaran: ' . $e->getMessage());

            // Kembalikan ke halaman sebelumnya dengan pesan error.
            return back()->with('error', 'Gagal mengonfirmasi booking. Terjadi kesalahan.');
        }
    }
}
