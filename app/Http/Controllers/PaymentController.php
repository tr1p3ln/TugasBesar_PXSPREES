<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use App\Notifications\ProofUploaded;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function show(Payment $payment)
    {
        $payment->load(['booking.room', 'booking.user']);

        return view('payments.show', [
            'payment' => $payment,
            'booking' => $payment->booking
        ]);
    }

    public function uploadProof(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'payment_method' => 'required|in:transfer,qr'
        ]);

        $path = $request->file('payment_proof')->store('payment_proofs', 'public');
        try {
            // Delete old proof if exists
            if ($payment->payment_proof) {
                Storage::disk('public')->delete($payment->payment_proof);
            }

            // Store new proof
            $path = $request->file('payment_proof')->store('payment_proofs');

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

    public function downloadProof(Payment $payment)
    {
        abort_unless(Storage::disk('public')->exists($payment->payment_proof), 404, 'File bukti tidak ditemukan.');

        return Storage::download($payment->payment_proof);
    }
}
