<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventLiturgicalRole extends Model
{
    protected $fillable = [
        'event_id',
        'parishioner_id',
        'user_id',
        'name',
        'phone',
        'parish',
        'role_type',
        'schedule_id',
        'assigned_time',
        'notes',
        'confirmed',
    ];

    protected $casts = [
        'assigned_time' => 'datetime',
        'confirmed' => 'boolean',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function parishioner(): BelongsTo
    {
        return $this->belongsTo(Parishioner::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(EventSchedule::class);
    }
}
