<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking; // Pastikan Anda punya model Booking
use App\Models\Room;    // Pastikan Anda punya model Room
use Carbon\Carbon;

class UpdateRoomStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-room-status'; // Nama command Anda

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates room status from Booked to Available after booking period ends';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Checking for bookings to update room status...');

        // Ambil semua booking yang statusnya 'confirmed'
        // dan waktu berakhirnya (start_time + duration_hour) sudah lewat
        $now = Carbon::now();

        $endedBookings = Booking::where('status', 'confirmed')
            // Filter booking yang seharusnya sudah selesai
            // Perlu query yang lebih presisi untuk menghitung waktu berakhir
            // Misalnya, jika start_time adalah DATETIME dan duration_hour adalah INTEGER
            ->whereRaw('TIMESTAMPADD(HOUR, duration_hour, start_time) < ?', [$now])
            ->get();

        if ($endedBookings->isEmpty()) {
            $this->info('No rooms to update.');
            return;
        }

        foreach ($endedBookings as $booking) {
            $room = Room::find($booking->room_id);
            if ($room && $room->status === 'Booked') {
                // Cek apakah masih ada booking aktif lain untuk ruangan ini
                // Ini penting jika ada kemungkinan overlap atau booking berdekatan
                $activeBookingsForRoom = Booking::where('room_id', $room->id)
                    ->where('status', 'confirmed')
                    ->where('start_time', '<=', $now) // Booking yang sedang berjalan atau akan segera
                    ->whereRaw('TIMESTAMPADD(HOUR, duration_hour, start_time) > ?', [$now])
                    ->exists();

                if (!$activeBookingsForRoom) {
                    $room->status = 'Available';
                    $room->save();
                    $this->info("Room ID {$room->id} status updated to Available.");
                } else {
                    $this->info("Room ID {$room->id} still has active bookings.");
                }
            }
        }
        $this->info('Room status update process finished.');
    }
}