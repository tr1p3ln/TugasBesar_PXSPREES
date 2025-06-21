<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'discount_amount' => 'decimal:2',
        'start_date'      => 'datetime',
        'end_date'        => 'datetime',
        'is_active'       => 'boolean',
    ];

    public function userVouchers(): HasMany
    {
        return $this->hasMany(UserVoucher::class);
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                $now = Carbon::now();
                if (!$this->is_active) {
                    return 'Tidak Aktif';
                }
                if ($now->isBefore($this->start_date)) {
                    return 'Terjadwal';
                }
                if ($now->isAfter($this->end_date)) {
                    return 'Kedaluwarsa';
                }
                return 'Aktif';
            },
        );
    }

    protected function statusColor(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                return match ($this->status) {
                    'Aktif'        => 'green',
                    'Terjadwal'    => 'blue',
                    'Kedaluwarsa'  => 'red',
                    'Tidak Aktif'  => 'gray',
                    default        => 'gray',
                };
            }
        );
    }
}