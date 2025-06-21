<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use App\Notifications\ProofUploaded;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * =========================================================
     * METHOD BARU UNTUK MENAMPILKAN HALAMAN HISTORY TRANSAKSI
     * =========================================================
     * Method inilah yang dicari oleh route 'admin.historydata' Anda.
     */
    // public function view(Request $request)
    // {
    //     // Ambil semua data pembayaran, diurutkan dari yang terbaru
    //     $payments = Payment::latest()->get();

    //     // Kirim data ke view 'admin.historydata'
    //     return view('admin.historydata', [
    //         'payments' => $payments
    //     ]);
    // }
    public function view(Request $request)
    {
        // 1. Ambil input tanggal dari request (URL).
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // 2. Buat query dasar untuk mengambil semua payment.
        //    Sertakan juga relasi agar efisien.
        $query = Payment::with(['booking.user', 'booking.room'])->latest();

        // 3. Jika ada input tanggal, terapkan filter 'whereBetween'.
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(), 
                Carbon::parse($endDate)->endOfDay()
            ]);
        }

        // 4. Eksekusi query untuk mendapatkan hasilnya.
        $payments = $query->get();

        // 5. Kirim data ke view.
        return view('admin.historydata', [
            'payments' => $payments,
            'start_date' => $startDate, // <-- VARIABEL INI HARUS DIKIRIM
            'end_date' => $endDate,     // <-- DAN VARIABEL INI JUGA
        ]);
    }


    //---------------------------------------------------------
    // Method di bawah ini adalah yang sudah Anda miliki sebelumnya
    // Tidak ada yang diubah, hanya ditata ulang.
    //---------------------------------------------------------

    /**
     * Menampilkan daftar pembayaran yang perlu dikonfirmasi oleh admin.
     */
    public function index()
    {
        $paymentsToConfirm = Payment::where('payment_status', 'pending')
            ->whereNotNull('payment_proof')
            ->with(['booking.user', 'booking.room'])
            ->latest()
            ->get();

        return view('admin.payments.index', compact('paymentsToConfirm'));
    }

    /**
     * Menampilkan detail satu pembayaran.
     */
    public function show(Payment $payment)
    {
        $payment->load(['booking.room', 'booking.user']);

        return view('payments.show', [
            'payment' => $payment,
            'booking' => $payment->booking
        ]);
    }

    /**
     * Mengizinkan admin mengubah status pembayaran (misal: dari pending ke paid).
     */
    public function updateStatus(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,paid,failed',
        ]);

        DB::beginTransaction();
        try {
            $payment->payment_status = $validated['status'];
            $payment->paid_at = ($validated['status'] === 'paid') ? now() : null;
            $payment->save();

            if ($validated['status'] === 'paid') {
                $payment->booking->status = 'confirmed';
            } elseif ($validated['status'] === 'failed') {
                $payment->booking->status = 'cancelled';
            } else {
                $payment->booking->status = 'pending';
            }
            $payment->booking->save();

            DB::commit();

            return back()->with('success', 'Status pembayaran berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Update Payment Status Failed: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui status pembayaran.');
        }
    }

    /**
     * Mengizinkan user mengunggah bukti pembayaran.
     */
    public function uploadProof(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'payment_method' => 'required|in:transfer,qr'
        ]);

        $path = $request->file('payment_proof')->store('payment_proofs', 'public');
        try {
            if ($payment->payment_proof) {
                Storage::disk('public')->delete($payment->payment_proof);
            }

            $path = $request->file('payment_proof')->store('payment_proofs', 'public');

            $payment->update([
                'payment_proof' => $path,
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'pending',
                'paid_at' => now(),
            ]);

            // Notify admins
            // User::where('role', 'admin')->get()->each(function ($admin) use ($payment) {
            //     $admin->notify(new ProofUploaded($payment));
            // });
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new ProofUploaded($payment));
            }

            return back()->with('success', 'Bukti pembayaran berhasil diunggah!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengunggah bukti: ' . $e->getMessage());
        }
    }

    /**
     * Mengizinkan admin men-download bukti pembayaran.
     */
    public function downloadProof(Payment $payment)
    {
        abort_unless(Storage::disk('public')->exists($payment->payment_proof), 404, 'File bukti tidak ditemukan.');

        return Storage::download($payment->payment_proof);
    }

    public function index()
        {
            $paymentsToConfirm = Payment::where('payment_status', 'pending')
                                        ->whereNotNull('payment_proof')
                                        ->with(['booking.user', 'booking.room'])
                                        ->latest()
                                        ->get();

            return view('admin.payments.pending_payments', compact('paymentsToConfirm')); // <-- Nama view baru
        }

    public function updateStatus(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,paid,failed',
        ]);

        // Gunakan transaksi untuk menjaga integritas data
        DB::beginTransaction();
        try {
            // 1. Update status payment
            $payment->payment_status = $validated['status'];
            
            // 2. Jika statusnya 'paid', catat tanggalnya. Jika tidak, kosongkan.
            $payment->paid_at = ($validated['status'] === 'paid') ? now() : null;
            $payment->save();

            // 3. Sinkronkan status booking yang terkait
            if ($validated['status'] === 'paid') {
                // Jika pembayaran lunas, booking dikonfirmasi
                $payment->booking->status = 'confirmed';
            } elseif ($validated['status'] === 'failed') {
                // Jika pembayaran gagal, booking dibatalkan
                $payment->booking->status = 'cancelled';
            } else {
                // Jika dikembalikan ke pending, booking juga pending
                $payment->booking->status = 'pending';
            }
            $payment->booking->save();
            
            // (Opsional) Kirim notifikasi ke user jika pembayaran dikonfirmasi
            // if ($payment->payment_status === 'paid') {
            //     $payment->booking->user->notify(new PaymentConfirmed($payment->booking));
            // }

            DB::commit(); // Simpan semua perubahan jika berhasil

            return back()->with('success', 'Status pembayaran berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan semua perubahan jika terjadi error
            // Tulis error ke log untuk debugging
            \Illuminate\Support\Facades\Log::error('Update Payment Status Failed: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui status pembayaran.');
        }
    }
}
