<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = [
        'name',
        'category',
        'description',
        'value',
        'acquisition_date',
        'status',
        'location',
        'maintenance_notes',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'acquisition_date' => 'date',
    ];
}
