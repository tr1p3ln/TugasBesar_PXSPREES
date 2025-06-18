<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Voucher extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_voucher',
        'description',
        'point_required',
        'voucher_code',
        'discount_amount',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'valid_until' => 'datetime',
        'discount_amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    // Relasi ke user_vouchers
    public function userVouchers(): HasMany
    {
        return $this->hasMany(UserVoucher::class);
    }
}
