<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke tabel bookings
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Relasi ke tabel user_vouchers
     */
    public function userVouchers(): HasMany
    {
        return $this->hasMany(UserVoucher::class);
    }

    /**
     * Alias untuk vouchers (kompatibilitas dengan kode sebelumnya)
     */


    public function vouchers(): HasMany
    {
        return $this->hasMany(UserVoucher::class)->with('voucher');
    }

    public function activeVouchers()
    {
        return $this->vouchers()
            ->where('is_used', false)
            ->whereHas('voucher', function ($query) {
                $query->where('valid_until', '>', now());
            });
    }
}
