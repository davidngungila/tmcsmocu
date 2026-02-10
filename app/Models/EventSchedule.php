<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventSchedule extends Model
{
    protected $fillable = [
        'event_id',
        'session_title',
        'description',
        'start_time',
        'end_time',
        'location',
        'leader_id',
        'speaker',
        'order',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function leader(): BelongsTo
    {
        return $this->belongsTo(Leader::class);
    }
}
