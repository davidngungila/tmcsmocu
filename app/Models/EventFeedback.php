<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventFeedback extends Model
{
    protected $table = 'event_feedbacks';
    
    protected $fillable = [
        'event_id',
        'parishioner_id',
        'name',
        'email',
        'rating',
        'feedback',
        'comments',
        'suggestions',
        'would_recommend',
        'is_anonymous',
    ];

    protected $casts = [
        'would_recommend' => 'boolean',
        'is_anonymous' => 'boolean',
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
