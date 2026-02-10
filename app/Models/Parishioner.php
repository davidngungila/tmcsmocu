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

    public function financialYears(): BelongsToMany
    {
        return $this->belongsToMany(FinancialYear::class, 'parishioner_financial_years')
            ->withPivot('status', 'joined_date', 'graduated_date', 'notes')
            ->withTimestamps();
    }

    /**
     * Get status for current financial year
     */
    public function getCurrentYearStatus()
    {
        $activeYear = FinancialYear::getActive();
        if (!$activeYear) {
            return null;
        }
        
        return $this->financialYears()
            ->where('financial_years.id', $activeYear->id)
            ->first()?->pivot;
    }

    /**
     * Check if parishioner is new in current financial year
     */
    public function isNewInCurrentYear(): bool
    {
        $status = $this->getCurrentYearStatus();
        return $status && $status->status === 'new';
    }

    /**
     * Check if parishioner graduated in current financial year
     */
    public function isGraduatedInCurrentYear(): bool
    {
        $status = $this->getCurrentYearStatus();
        return $status && $status->status === 'graduated';
    }

    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }
}
