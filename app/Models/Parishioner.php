<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Parishioner extends Model
{
    protected $fillable = [
        'type',
        'first_name',
        'last_name',
        'middle_name',
        'contact_number',
        'phone',
        'email',
        'date_of_birth',
        'gender',
        'address',
        'occupation',
        'registration_date',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'registration_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function communities(): BelongsToMany
    {
        return $this->belongsToMany(Community::class, 'parishioner_community')->withPivot('joined_date', 'is_active')->withTimestamps();
    }

    public function apostolicGroups(): BelongsToMany
    {
        return $this->belongsToMany(ApostolicGroup::class, 'parishioner_apostolic_group')->withPivot('joined_date', 'is_active')->withTimestamps();
    }

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_attendances')->withPivot('attended', 'checked_in_at', 'notes')->withTimestamps();
    }

    public function eventAttendances()
    {
        return $this->hasMany(EventAttendance::class);
    }

    public function leaderPositions()
    {
        return $this->hasMany(Leader::class);
    }

    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }
}
