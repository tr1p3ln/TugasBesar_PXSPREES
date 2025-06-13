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
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        try {
            // Delete old proof if exists
            if ($payment->payment_proof) {
                Storage::delete($payment->payment_proof);
            }

            // Store new proof
            $path = $request->file('payment_proof')->store('payment_proofs');

            $payment->update([
                'payment_proof' => $path,
                'payment_status' => Payment::STATUS_PENDING
            ]);

            // Notify admins
            User::role('admin')->each(function ($admin) use ($payment) {
                $admin->notify(new ProofUploaded($payment));
            });

            return back()->with('success', 'Bukti pembayaran berhasil diunggah!');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengunggah bukti: ' . $e->getMessage());
        }
    }

    public function downloadProof(Payment $payment)
    {
        abort_unless(Storage::exists($payment->payment_proof), 404);

        return Storage::download($payment->payment_proof);
    }
}