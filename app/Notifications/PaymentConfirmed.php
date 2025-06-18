<?php
namespace App\Notifications;
use App\Models\Booking;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
// ...
class PaymentConfirmed extends Notification implements ShouldQueue
{
    // ...
    public $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database', 'broadcast'];
    }

    public function toMail($notifiable): MailMessage
    {
        $url = url('/user/payment/' . $this->booking->id);

        return (new MailMessage)
                    ->subject('Pembayaran Dikonfirmasi!')
                    ->greeting('Halo, ' . $notifiable->name . '!')
                    ->line('Kabar baik! Pembayaran untuk booking Anda #' . $this->booking->id . ' telah kami konfirmasi.')
                    ->line('Detail Ruangan: ' . $this->booking->room->name)
                    ->line('Waktu: ' . $this->booking->start_time->format('d F Y, H:i'))
                    ->action('Lihat Detail Booking', $url)
                    ->line('Selamat bermain!');
    }

    public function toArray($notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'message' => 'Pembayaran untuk booking #' . $this->booking->id . ' telah dikonfirmasi!',
            'url' => url('/user/payment/' . $this->booking->id),
        ];
    }
}