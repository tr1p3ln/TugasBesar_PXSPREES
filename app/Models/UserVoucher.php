<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserVoucher extends Model
{
    protected $fillable = [
        'user_id',
        'voucher_id',
        'claimed_at',
        'is_used'
    ];

    protected $casts = [
        'claimed_at' => 'datetime',
        'is_used' => 'boolean'
    ];

    // Relasi ke user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke voucher master
    public function voucher(): BelongsTo
    {
        return $this->belongsTo(Voucher::class);
    }

    // Relasi ke bookings
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'user_voucher_id');
    }
}