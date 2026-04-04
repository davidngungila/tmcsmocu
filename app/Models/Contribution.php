<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contribution extends Model
{
    protected $fillable = [
        'parishioner_id',
        'financial_year_id',
        'contribution_type',
        'amount',
        'payment_method',
        'transaction_reference',
        'contribution_date',
        'description',
        'receipt_number',
        'status',
        'recorded_by',
    ];

    protected $casts = [
        'contribution_date' => 'date',
        'amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function parishioner(): BelongsTo
    {
        return $this->belongsTo(Parishioner::class);
    }

    public function financialYear(): BelongsTo
    {
        return $this->belongsTo(FinancialYear::class);
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function receipts(): HasMany
    {
        return $this->hasMany(Receipt::class);
    }

    // Scopes
    public function scopeByType($query, $type)
    {
        return $query->where('contribution_type', $type);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeInFinancialYear($query, $yearId)
    {
        return $query->where('financial_year_id', $yearId);
    }

    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('contribution_date', [$startDate, $endDate]);
    }

    // Accessors
    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->amount, 2);
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'confirmed' => 'green',
            'pending' => 'yellow',
            'cancelled' => 'red',
            default => 'gray'
        };
    }

    // Constants
    public const TYPES = [
        'tithe' => 'Tithe',
        'offering' => 'Offering',
        'special' => 'Special Collection',
        'thanksgiving' => 'Thanksgiving',
        'building_fund' => 'Building Fund',
        'mission' => 'Mission Support',
        'welfare' => 'Welfare Fund',
    ];

    public const PAYMENT_METHODS = [
        'cash' => 'Cash',
        'mobile_money' => 'Mobile Money',
        'bank' => 'Bank Transfer',
        'cheque' => 'Cheque',
    ];
}
