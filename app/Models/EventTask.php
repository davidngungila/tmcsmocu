<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventTask extends Model
{
    protected $fillable = [
        'event_id',
        'title',
        'description',
        'task_type',
        'assigned_to',
        'assigned_parishioner_id',
        'status',
        'due_date',
        'completed_at',
        'notes',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function assignedParishioner(): BelongsTo
    {
        return $this->belongsTo(Parishioner::class, 'assigned_parishioner_id');
    }
}
