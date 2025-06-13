<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Voucher extends Model
{
    protected $fillable = [
        'code',
        'discount_amount',
        'valid_until',
        'max_usage'
    ];

    protected $casts = [
        'valid_until' => 'datetime',
        'discount_amount' => 'decimal:2'
    ];

    // Relasi ke user_vouchers
    public function userVouchers(): HasMany
    {
        return $this->hasMany(UserVoucher::class);
    }
}