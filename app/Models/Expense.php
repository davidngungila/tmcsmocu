<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    protected $fillable = [
        'financial_year_id',
        'expense_category',
        'expense_type',
        'description',
        'amount',
        'expense_date',
        'payment_method',
        'vendor',
        'invoice_number',
        'notes',
        'status',
        'approved_by',
        'paid_by',
        'receipt_attachment',
    ];

    protected $casts = [
        'expense_date' => 'date',
        'amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function financialYear(): BelongsTo
    {
        return $this->belongsTo(FinancialYear::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function paidBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'paid_by');
    }

    // Scopes
    public function scopeByCategory($query, $category)
    {
        return $query->where('expense_category', $category);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('expense_type', $type);
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
        return $query->whereBetween('expense_date', [$startDate, $endDate]);
    }

    // Accessors
    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->amount, 2);
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'paid' => 'green',
            'approved' => 'blue',
            'pending' => 'yellow',
            'cancelled' => 'red',
            default => 'gray'
        };
    }

    // Constants
    public const CATEGORIES = [
        'utilities' => 'Utilities',
        'maintenance' => 'Maintenance',
        'salaries' => 'Salaries',
        'office_supplies' => 'Office Supplies',
        'events' => 'Events',
        'missions' => 'Missions',
        'building' => 'Building Fund',
        'welfare' => 'Welfare',
        'transport' => 'Transportation',
        'communication' => 'Communication',
        'insurance' => 'Insurance',
        'taxes' => 'Taxes',
    ];

    public const TYPES = [
        'operational' => 'Operational',
        'capital' => 'Capital Expenditure',
        'emergency' => 'Emergency',
        'program' => 'Program Costs',
    ];

    public const PAYMENT_METHODS = [
        'cash' => 'Cash',
        'bank_transfer' => 'Bank Transfer',
        'mobile_money' => 'Mobile Money',
        'cheque' => 'Cheque',
    ];
}
