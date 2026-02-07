<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SmsRecipient extends Model
{
    protected $fillable = [
        'campaign_id',
        'batch_id',
        'parishioner_id',
        'phone_number',
        'status',
        'error_message',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(SmsCampaign::class, 'campaign_id');
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(SmsBatch::class, 'batch_id');
    }

    public function parishioner(): BelongsTo
    {
        return $this->belongsTo(Parishioner::class);
    }
}
