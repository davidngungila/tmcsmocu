<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'receipt_number',
        'customer_name',
        'customer_phone',
        'customer_email',
        'subtotal',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'payment_method',
        'payment_status',
        'status',
        'notes',
        'sold_by',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'sale_date' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'sold_by');
    }

    public function getFormattedSubtotalAttribute()
    {
        return number_format($this->subtotal, 2, '.', ',');
    }

    public function getFormattedTaxAmountAttribute()
    {
        return number_format($this->tax_amount, 2, '.', ',');
    }

    public function getFormattedDiscountAmountAttribute()
    {
        return number_format($this->discount_amount, 2, '.', ',');
    }

    public function getFormattedTotalAmountAttribute()
    {
        return number_format($this->total_amount, 2, '.', ',');
    }

    public function getPaymentStatusColorAttribute()
    {
        return match($this->payment_status) {
            'paid' => 'green',
            'partial' => 'yellow',
            'pending' => 'red',
            default => 'gray',
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'completed' => 'green',
            'pending' => 'yellow',
            'cancelled' => 'red',
            'refunded' => 'orange',
            default => 'gray',
        };
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('sale_date', [$startDate, $endDate]);
    }

    public function scopeByPaymentMethod($query, $paymentMethod)
    {
        return $query->where('payment_method', $paymentMethod);
    }

    public function scopeByPaymentStatus($query, $paymentStatus)
    {
        return $query->where('payment_status', $paymentStatus);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('sale_date', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('sale_date', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('sale_date', now()->month)
                    ->whereYear('sale_date', now()->year);
    }
}
