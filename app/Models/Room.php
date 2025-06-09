<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    // Field yang dapat diisi
    protected $fillable = [
        'name',
        'console_type',
        'price_per_hour',
        'description',
        'image_url',
    ];

    // Jika kamu ingin membatasi enum di model (opsional)
    public const CONSOLE_TYPES = ['Nintendo', 'Playstation', 'VIP'];

    // Cast tipe data
    protected $casts = [
        'price_per_hour' => 'decimal:2',
    ];
}
