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
        return $this->belongsToMany(Community::class)->withPivot('joined_date', 'is_active')->withTimestamps();
    }

    public function apostolicGroups(): BelongsToMany
    {
        return $this->belongsToMany(ApostolicGroup::class)->withPivot('joined_date', 'is_active')->withTimestamps();
    }

    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }
}
