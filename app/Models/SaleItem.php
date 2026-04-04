<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaleItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'unit_price',
        'total_price',
        'discount_amount',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'discount_amount' => 'decimal:2',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getFormattedUnitPriceAttribute()
    {
        return number_format($this->unit_price, 2, '.', ',');
    }

    public function getFormattedTotalPriceAttribute()
    {
        return number_format($this->total_price, 2, '.', ',');
    }

    public function getFormattedDiscountAmountAttribute()
    {
        return number_format($this->discount_amount, 2, '.', ',');
    }

    public function getFinalPriceAttribute()
    {
        return $this->total_price - $this->discount_amount;
    }

    public function getFormattedFinalPriceAttribute()
    {
        return number_format($this->final_price, 2, '.', ',');
    }
}
