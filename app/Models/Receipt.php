<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Receipt extends Model
{
    protected $fillable = [
        'contribution_id',
        'parishioner_id',
        'receipt_number',
        'amount',
        'receipt_date',
        'payment_method',
        'payment_status',
        'transaction_reference',
        'description',
        'type',
        'issued_by',
    ];

    protected $casts = [
        'receipt_date' => 'date',
        'amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function contribution(): BelongsTo
    {
        return $this->belongsTo(Contribution::class);
    }

    public function parishioner(): BelongsTo
    {
        return $this->belongsTo(Parishioner::class);
    }

    public function issuedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    // Scopes
    public function scopeByPaymentStatus($query, $status)
    {
        return $query->where('payment_status', $status);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('receipt_date', [$startDate, $endDate]);
    }

    // Accessors
    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->amount, 2);
    }

    public function getPaymentStatusColorAttribute(): string
    {
        return match($this->payment_status) {
            'paid' => 'green',
            'partial' => 'yellow',
            'pending' => 'orange',
            default => 'gray'
        };
    }

    // Constants
    public const TYPES = [
        'contribution' => 'Contribution',
        'donation' => 'Donation',
        'special_collection' => 'Special Collection',
    ];

    public const PAYMENT_STATUSES = [
        'paid' => 'Paid',
        'partial' => 'Partial',
        'pending' => 'Pending',
    ];
}
