<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BookingController;

class PaymentController extends Controller
{
    /**
     * Menampilkan daftar pembayaran yang perlu dikonfirmasi.
     */
    public function index()
    {
        // Ambil data pembayaran yang statusnya 'pending' DAN sudah ada bukti bayar
        $paymentsToConfirm = Payment::where('payment_status', 'pending')
                                    ->whereNotNull('payment_proof')
                                    ->with(['booking.user', 'booking.room']) // Eager load relasi
                                    ->latest() // Tampilkan yang terbaru dulu
                                    ->get();

        // Kirim data ke view baru yang akan kita buat
        return view('admin.payments.index', compact('paymentsToConfirm'));
    }

    /**
     * Mengubah status pembayaran (Konfirmasi atau Tolak).
     */
    public function updateStatus(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'status' => 'required|in:paid,failed', // Hanya boleh diubah menjadi 'paid' atau 'failed'
        ]);

        // Gunakan transaksi untuk menjaga integritas data
        DB::beginTransaction();
        try {
            // Update status pembayaran
            $payment->payment_status = $validated['status'];
            $payment->paid_at = ($validated['status'] === 'paid') ? now() : null;
            $payment->save();

            // Jika pembayaran berhasil (paid), update juga status booking menjadi 'confirmed'
            if ($validated['status'] === 'paid') {
                $payment->booking->status = 'confirmed';
                $payment->booking->save();
            }
            
            // Jika pembayaran gagal (failed), Anda bisa menambahkan logika lain,
            // misalnya mengembalikan status booking menjadi 'pending' atau 'cancelled'.
            // Untuk sekarang, kita hanya update status payment.

            DB::commit(); // Simpan semua perubahan jika berhasil

            return back()->with('success', 'Status pembayaran berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan semua perubahan jika terjadi error
            return back()->with('error', 'Gagal memperbarui status pembayaran: ' . $e->getMessage());
        }
    }
}