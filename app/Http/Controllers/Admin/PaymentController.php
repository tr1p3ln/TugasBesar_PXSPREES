<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon; // Pastikan Carbon di-import

class PaymentController extends Controller
{
    /**
     * Menampilkan daftar pembayaran yang perlu dikonfirmasi.
     */
    public function index()
    {
        $paymentsToConfirm = Payment::where('payment_status', 'pending')
                                    ->whereNotNull('payment_proof')
                                    ->with(['booking.user', 'booking.room'])
                                    ->latest()
                                    ->get();

        return view('admin.payments.pending_payments', compact('paymentsToConfirm'));
    }

    /**
     * ===============================================
     * METHOD BARU UNTUK MENAMPILKAN RIWAYAT TRANSAKSI
     * ===============================================
     */
    public function history(Request $request)
    {
        // 1. Ambil input tanggal dari request (URL).
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // 2. Buat query dasar untuk mengambil semua payment.
        $query = Payment::with(['booking.user', 'booking.room'])->latest();

        // 3. Jika ada input tanggal, terapkan filter.
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(), 
                Carbon::parse($endDate)->endOfDay()
            ]);
        }

        // 4. Eksekusi query.
        $payments = $query->get();

        // 5. Kirim data ke view historydata.
        return view('admin.historydata', [
            'payments' => $payments,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);
    }


    /**
     * Mengubah status pembayaran (Konfirmasi atau Tolak).
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
            return back()->with('error', 'Gagal memperbarui status pembayaran: ' . $e->getMessage());
        }
    }
}
