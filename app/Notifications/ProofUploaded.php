<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ProofUploaded extends Notification implements ShouldQueue
{
    use Queueable;

    public $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database', 'broadcast'];
    }

    public function toMail($notifiable): MailMessage
    {
        $booking = $this->payment->booking;
        $url = route('admin.payments.show', $this->payment->id);

        return (new MailMessage)
            ->subject('Bukti Pembayaran Baru - Booking #' . $booking->id)
            ->greeting('Halo Admin!')
            ->line('Bukti pembayaran baru telah diunggah untuk booking berikut:')
            ->line('Booking ID: #' . $booking->id)
            ->line('Ruangan: ' . $booking->room->name)
            ->line('Tanggal: ' . $booking->start_time->translatedFormat('l, d F Y'))
            ->line('Waktu: ' . $booking->start_time->format('H:i') . ' - ' . $booking->end_time->format('H:i'))
            ->line('User: ' . $booking->user->name)
            ->line('Jumlah: Rp' . number_format($this->payment->amount, 0, ',', '.'))
            ->action('Verifikasi Pembayaran', $url)
            ->line('Harap verifikasi dalam waktu 24 jam.');
    }

    public function toDatabase($notifiable): array
    {
        return $this->toArray($notifiable);
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }

    public function toArray($notifiable): array
    {
        $booking = $this->payment->booking;

        return [
            'type' => 'payment_proof_uploaded',
            'booking_id' => $booking->id,
            'payment_id' => $this->payment->id,
            'user_name' => $booking->user->name,
            'room_name' => $booking->room->name,
            'amount' => $this->payment->amount,
            'message' => 'Bukti pembayaran baru untuk Booking #' . $booking->id,
            'url' => route('admin.payments.show', $this->payment->id),
            'icon' => 'fa-upload',
            'time' => now()->toDateTimeString()
        ];
    }
}