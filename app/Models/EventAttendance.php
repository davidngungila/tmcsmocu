<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventAttendance extends Model
{
    protected $fillable = [
        'event_id',
        'parishioner_id',
        'attended',
        'checked_in_at',
        'notes',
    ];

    protected $casts = [
        'attended' => 'boolean',
        'checked_in_at' => 'datetime',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function parishioner(): BelongsTo
    {
        return $this->belongsTo(Parishioner::class);
    }
}
