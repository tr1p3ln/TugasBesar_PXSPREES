<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use App\Notifications\ProofUploaded;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;

class PaymentController extends Controller
{
    /**
     * Menampilkan halaman history transaksi untuk admin dengan filter tanggal.
     * Method ini digunakan oleh route 'admin.historydata' atau 'admin.payments.history'.
     */
    public function view(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Payment::with(['booking.user', 'booking.room'])->latest();

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);
        }

        $payments = $query->get();

        return view('admin.historydata', [
            'payments' => $payments,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);
    }

    /**
     * Menampilkan daftar pembayaran yang perlu dikonfirmasi oleh admin.
     * Method ini untuk halaman khusus konfirmasi.
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
            ]);

            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new ProofUploaded($payment));
            }

            return back()->with('success', 'Bukti pembayaran berhasil diunggah!');
        } catch (\Exception $e) {
            Log::error('Upload Proof Failed: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengunggah bukti. Silakan coba lagi.');
        }
    }

    /**
     * Mengizinkan user/admin men-download bukti pembayaran.
     */
    public function downloadProof(Payment $payment)
    {
        // Pastikan properti payment_proof ada dan tidak kosong
        abort_if(!$payment->payment_proof, 404, 'Bukti pembayaran tidak tersedia.');

        // Pastikan file benar-benar ada di storage sebelum mencoba download
        abort_unless(Storage::disk('public')->exists($payment->payment_proof), 404, 'File bukti tidak ditemukan.');

        // Gunakan method download dari Storage facade
        // return Storage::disk('public')->download($payment->payment_proof);
        $filePath = storage_path('app/public/' . $payment->payment_proof);
        return response()->download($filePath);
    }

    /**
     * Mengekspor data transaksi ke dalam format PDF.
     */
    public function exportPDF(Request $request)
    {
        $startDateInput = $request->input('start_date') ?? Carbon::now()->startOfMonth()->toDateString();
        $endDateInput = $request->input('end_date') ?? Carbon::now()->endOfMonth()->toDateString();

        $startDate = Carbon::parse($startDateInput)->startOfDay();
        $endDate = Carbon::parse($endDateInput)->endOfDay();

        $payments = Payment::with(['booking.user', 'booking.room'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->get();

        $totalAmount = $payments->where('payment_status', 'paid')->sum('amount');

        $data = [
            'payments' => $payments,
            'totalAmount' => $totalAmount,
            'startDate' => $startDate->format('d M Y'),
            'endDate' => $endDate->format('d M Y'),
        ];

        // Gunakan facade Pdf yang sudah di-import
        $pdf = Pdf::loadView('admin.history_pdf', $data);

        return $pdf->download('laporan-transaksi-' . $startDate->format('Y-m-d') . '-sampai-' . $endDate->format('Y-m-d') . '.pdf');
    }
}
