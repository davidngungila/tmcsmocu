<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class EventRegistration extends Model
{
    protected $fillable = [
        'event_id',
        'parishioner_id',
        'name',
        'phone',
        'email',
        'participant_type',
        'status',
        'special_requirements',
        'qr_code',
        'registered_at',
        'confirmed_at',
    ];

    protected $casts = [
        'registered_at' => 'datetime',
        'confirmed_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($registration) {
            if (empty($registration->qr_code)) {
                $registration->qr_code = 'REG-' . strtoupper(Str::random(12));
            }
            if (empty($registration->registered_at)) {
                $registration->registered_at = now();
            }
        });
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function parishioner(): BelongsTo
    {
        return $this->belongsTo(Parishioner::class);
    }

    public function attendance()
    {
        return $this->hasOne(EventAttendance::class, 'registration_id');
    }
}
