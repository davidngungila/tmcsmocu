<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Community extends Model
{
    protected $fillable = [
        'name',
        'academic_programme',
        'description',
        'chairperson_name',
        'chairperson_email',
        'chairperson_phone',
        'secretary_name',
        'secretary_email',
        'secretary_phone',
        'treasurer_name',
        'treasurer_email',
        'treasurer_phone',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function parishioners(): HasMany
    {
        return $this->hasMany(Parishioner::class);
    }

    public function activeParishioners(): HasMany
    {
        return $this->hasMany(Parishioner::class)->where('status', 'active');
    }

    public function studentParishioners(): HasMany
    {
        return $this->hasMany(Parishioner::class)->where('member_type', 'student')->where('status', 'active');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByProgramme($query, $programme)
    {
        return $query->where('academic_programme', $programme);
    }

    public function getMemberCountAttribute(): int
    {
        return $this->activeParishioners()->count();
    }

    public function getStudentCountAttribute(): int
    {
        return $this->studentParishioners()->count();
    }
}
