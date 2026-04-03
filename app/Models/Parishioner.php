<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Parishioner extends Model
{
    protected $fillable = [
        'member_type',
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
        // Student specific
        'registration_number',
        'academic_programme',
        'year_of_study',
        // Employee specific
        'employee_id',
        'department',
        // Child specific
        'guardian_name',
        'guardian_phone',
        'guardian_id',
        // Relationships
        'community_id',
        'status',
        'photo',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'registration_date' => 'date',
        'is_active' => 'boolean',
        'member_type' => 'string',
        'status' => 'string',
    ];

    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }

    public function spiritualGroups(): BelongsToMany
    {
        return $this->belongsToMany(ApostolicGroup::class, 'parishioner_apostolic_group')
            ->withPivot('role', 'joined_at')
            ->withTimestamps();
    }

    public function ledGroups(): BelongsToMany
    {
        return $this->spiritualGroups()->wherePivot('role', 'leader');
    }

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_attendances')->withPivot('attended', 'checked_in_at', 'notes')->withTimestamps();
    }

    public function eventAttendances(): HasMany
    {
        return $this->hasMany(EventAttendance::class);
    }

    public function guardianChildren(): HasMany
    {
        return $this->hasMany(Parishioner::class, 'guardian_id');
    }

    public function guardian(): BelongsTo
    {
        return $this->belongsTo(Parishioner::class, 'guardian_id');
    }

    public function leaderPositions(): HasMany
    {
        return $this->hasMany(Leader::class);
    }

    public function financialYears(): BelongsToMany
    {
        return $this->belongsToMany(FinancialYear::class, 'parishioner_financial_years')
            ->withPivot('status', 'joined_date', 'graduated_date', 'notes')
            ->withTimestamps();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeStudents($query)
    {
        return $query->where('member_type', 'student');
    }

    public function scopeEmployees($query)
    {
        return $query->where('member_type', 'employee');
    }

    public function scopeChildren($query)
    {
        return $query->where('member_type', 'child');
    }

    public function scopeByProgramme($query, $programme)
    {
        return $query->where('academic_programme', $programme);
    }

    public function scopeByYear($query, $year)
    {
        return $query->where('year_of_study', $year);
    }

    // Accessors
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->middle_name} {$this->last_name}";
    }

    public function getRegistrationNumberFormattedAttribute(): string
    {
        if ($this->member_type === 'student' && $this->registration_number) {
            return $this->registration_number;
        }
        return '';
    }

    public function isStudent(): bool
    {
        return $this->member_type === 'student';
    }

    public function isEmployee(): bool
    {
        return $this->member_type === 'employee';
    }

    public function isChild(): bool
    {
        return $this->member_type === 'child';
    }

    public static function getAcademicProgrammes(): array
    {
        return [
            'BAPSM' => 'Bachelor of Arts in Political Science and Management',
            'BBICT' => 'Bachelor of Business in Information and Communication Technology',
            'BHRM' => 'Bachelor of Human Resource Management',
            'LLB' => 'Bachelor of Laws',
            'BCOM' => 'Bachelor of Commerce',
            'BAMS' => 'Bachelor of Agricultural Management and Sciences',
            'BENG' => 'Bachelor of Engineering',
            'BSC' => 'Bachelor of Science',
            'BFA' => 'Bachelor of Fine and Applied Arts',
            'BED' => 'Bachelor of Education',
            'BN' => 'Bachelor of Nursing',
            'BPHARM' => 'Bachelor of Pharmacy',
            'BARCH' => 'Bachelor of Architecture',
            'BVM' => 'Bachelor of Veterinary Medicine',
            'BDS' => 'Bachelor of Dental Surgery',
            'BMLS' => 'Bachelor of Medical Laboratory Sciences',
            'BNS' => 'Bachelor of Nursing Science',
            'BMID' => 'Bachelor of Midwifery',
        ];
    }

    public static function getStudyYears(): array
    {
        $currentYear = date('Y');
        $years = [];
        
        for ($year = $currentYear; $year >= ($currentYear - 6); $year--) {
            $years[$year] = $year;
        }
        
        return $years;
    }

    public static function getRegions(): array
    {
        return [
            'AR' => 'Arusha',
            'DS' => 'Dar es Salaam',
            'DO' => 'Dodoma',
            'IR' => 'Iringa',
            'KB' => 'Kilimanjaro',
            'KS' => 'Kigoma',
            'MJ' => 'Morogoro',
            'MB' => 'Mbeya',
            'MT' => 'Morogoro',
            'MU' => 'Mwanza',
            'MW' => 'Mtwara',
            'PK' => 'Pwani',
            'RU' => 'Ruvuma',
            'SH' => 'Shinyanga',
            'SI' => 'Simiyu',
            'TE' => 'Tabora',
            'TI' => 'Tanga',
        ];
    }

    public function getMemberTypeLabelAttribute(): string
    {
        return match($this->member_type) {
            'student' => 'Student',
            'employee' => 'Employee',
            'child' => 'Child',
            default => 'Unknown',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'active' => 'Active',
            'alumni' => 'Alumni',
            'inactive' => 'Inactive',
            default => 'Unknown',
        };
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
}
