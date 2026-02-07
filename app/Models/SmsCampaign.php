<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SmsCampaign extends Model
{
    protected $fillable = [
        'title',
        'message',
        'language',
        'status',
        'created_by',
        'approved_by',
        'approved_at',
        'rejection_reason',
        'target_criteria',
        'recipient_count',
        'provider_id',
    ];

    protected $casts = [
        'target_criteria' => 'array',
        'approved_at' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function batches(): HasMany
    {
        return $this->hasMany(SmsBatch::class, 'campaign_id');
    }

    public function recipients(): HasMany
    {
        return $this->hasMany(SmsRecipient::class, 'campaign_id');
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(NotificationProvider::class, 'provider_id');
    }
}
