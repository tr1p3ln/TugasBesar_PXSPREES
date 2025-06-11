<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    protected $fillable = [
        'name',
        'console_type', 
        'price_per_hour',
        'description', 
        'status'      
    ];

    // Relasi ke bookings
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
