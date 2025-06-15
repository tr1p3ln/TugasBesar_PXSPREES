<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'booking_id',
        'payment_method',
        'payment_status',
        'amount',
        'payment_proof',
        'paid_at',
        'notes'
    ];


    protected $guarded = ['id'];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    // Payment status constants
    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';
    const STATUS_FAILED = 'failed';
    const STATUS_REFUNDED = 'refunded';

    // Payment method constants
    const METHOD_TRANSFER = 'transfer';
    const METHOD_QR = 'qr';

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function markAsPaid(): void
    {
        $this->update([
            'payment_status' => self::STATUS_PAID,
            'paid_at' => now()
        ]);
    }

    public function getFormattedAmountAttribute(): string
    {
        return 'Rp' . number_format($this->amount, 0, ',', '.');
    }
}