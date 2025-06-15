<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Booking extends Model
{
    protected $fillable = [
        'user_id', 
        'room_id',
        'user_voucher_id',
        'start_time',
        'duration_hour',
        'status',
        'total_price'
    ];

    protected $casts = [
        'start_time' => 'datetime'
    ];

    // Relasi ke user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke room
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    // Relasi ke voucher (jika digunakan)
    public function voucher(): BelongsTo
    {
        return $this->belongsTo(UserVoucher::class, 'user_voucher_id');
    }

    // public function payment(): HasOne
    // {
    //     return $this->hasOne(Payment::class);
    // }

    public function getEndTimeAttribute(): Carbon
    {
        return $this->start_time->copy()->addHours($this->duration_hour);
    }
}