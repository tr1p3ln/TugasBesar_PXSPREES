<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use App\Notifications\ProofUploaded;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Tambahkan ini untuk logging error
// use Barryvdh\DomPDF\Facade\Pdfl;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;


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

        try {
            if ($payment->payment_proof) {
                Storage::disk('public')->delete($payment->payment_proof);
            }

            $path = $request->file('payment_proof')->store('payment_proofs', 'public');

            $payment->update([
                'payment_proof' => $path,
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'pending',
                // 'paid_at' => now(), // <-- Lihat saran perbaikan di bawah
            ]);

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

        $path = Storage::disk('public')->path($payment->payment_proof);
        $filename = basename($path);

        return response()->download($path, $filename);
    }

    /**
     * =========================================================
     * METHOD BARU UNTUK EXPORT PDF
     * =========================================================
     */
    public function exportPDF(Request $request)
    {
        // 1. Ambil data dengan logika filter yang sama seperti method view()
        $startDateInput = $request->input('start_date') ?? Carbon::now()->startOfMonth()->toDateString();
        $endDateInput = $request->input('end_date') ?? Carbon::now()->endOfMonth()->toDateString();

        $startDate = Carbon::parse($startDateInput)->startOfDay();
        $endDate = Carbon::parse($endDateInput)->endOfDay();

        $payments = Payment::with(['booking.user', 'booking.room'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->get();
            
        // Hitung total pendapatan untuk ditampilkan di footer PDF
        $totalAmount = $payments->where('payment_status', 'paid')->sum('amount');

        // 2. Siapkan data untuk dikirim ke view PDF
        $data = [
            'payments' => $payments,
            'totalAmount' => $totalAmount,
            'startDate' => $startDate->format('d M Y'),
            'endDate' => $endDate->format('d M Y'),
        ];

        // 3. Load view PDF dengan data, lalu buat PDF-nya
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.history_pdf', $data);

        // 4. Download file PDF dengan nama dinamis
        return $pdf->download('laporan-transaksi-' . $startDate->format('Y-m-d') . '-' . $endDate->format('Y-m-d') . '.pdf');
    }
}
