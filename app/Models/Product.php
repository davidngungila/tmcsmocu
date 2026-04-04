<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'sku',
        'barcode',
        'category',
        'price',
        'cost_price',
        'stock_quantity',
        'reorder_level',
        'reorder_quantity',
        'unit',
        'supplier',
        'status',
        'image',
        'notes',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'reorder_level' => 'integer',
        'reorder_quantity' => 'integer',
        'status' => 'boolean',
    ];

    public function getStockStatusAttribute()
    {
        if ($this->stock_quantity == 0) {
            return 'out_of_stock';
        } elseif ($this->stock_quantity <= $this->reorder_level) {
            return 'low_stock';
        } else {
            return 'in_stock';
        }
    }

    public function getStockStatusColorAttribute()
    {
        return match($this->stock_status) {
            'out_of_stock' => 'red',
            'low_stock' => 'yellow',
            'in_stock' => 'green',
            default => 'gray',
        };
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 2, '.', ',');
    }

    public function getFormattedCostPriceAttribute()
    {
        return number_format($this->cost_price, 2, '.', ',');
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }

    public function scopeLowStock($query)
    {
        return $query->where('stock_quantity', '<=', $this->reorder_level)
                    ->where('stock_quantity', '>', 0);
    }

    public function scopeOutOfStock($query)
    {
        return $query->where('stock_quantity', '=', 0);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
