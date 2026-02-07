<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Leader extends Model
{
    protected $fillable = [
        'parishioner_id',
        'position',
        'responsibilities',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function parishioner(): BelongsTo
    {
        return $this->belongsTo(Parishioner::class);
    }
}
