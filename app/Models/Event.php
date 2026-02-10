<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Event extends Model
{
    protected $fillable = [
        'type',
        'category',
        'title',
        'theme',
        'spiritual_theme',
        'scripture_readings',
        'description',
        'program_flow',
        'start_date',
        'end_date',
        'location',
        'parish',
        'priest_name',
        'liturgical_color',
        'community',
        'expected_attendance',
        'budget',
        'registration_required',
        'registration_deadline',
        'max_participants',
        'requires_approval',
        'approval_level',
        'qr_code',
        'is_active',
        'status',
        'send_reminders',
        'announcement',
        'cover_image',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'registration_deadline' => 'datetime',
        'is_active' => 'boolean',
        'registration_required' => 'boolean',
        'send_reminders' => 'boolean',
        'budget' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($event) {
            if (empty($event->qr_code)) {
                $event->qr_code = 'EVT-' . strtoupper(Str::random(10));
            }
        });
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(EventAttendance::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(EventSchedule::class)->orderBy('start_time');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(EventTask::class);
    }

    public function media(): HasMany
    {
        return $this->hasMany(EventMedia::class);
    }

    public function finances(): HasMany
    {
        return $this->hasMany(EventFinance::class);
    }

    public function feedbacks(): HasMany
    {
        return $this->hasMany(EventFeedback::class);
    }

    public function liturgicalRoles(): HasMany
    {
        return $this->hasMany(EventLiturgicalRole::class);
    }

    public function approvals(): HasMany
    {
        return $this->hasMany(EventApproval::class);
    }

    public function getLatestApprovalAttribute()
    {
        return $this->approvals()->latest()->first();
    }

    public function isFullyApproved(): bool
    {
        if (!$this->requires_approval) {
            return true;
        }

        $requiredLevels = [];
        if ($this->approval_level === 'diocese') {
            $requiredLevels = ['parish_coordinator', 'pastor', 'diocese'];
        } elseif ($this->approval_level === 'pastor') {
            $requiredLevels = ['parish_coordinator', 'pastor'];
        } else {
            $requiredLevels = ['parish_coordinator'];
        }

        foreach ($requiredLevels as $level) {
            $approval = $this->approvals()->where('approval_level', $level)->where('status', 'approved')->first();
            if (!$approval) {
                return false;
            }
        }

        return true;
    }

    // Helper methods
    public function getTotalRegistrationsAttribute()
    {
        return $this->registrations()->where('status', 'confirmed')->count();
    }

    public function getTotalAttendanceAttribute(): int
    {
        return $this->attendances()->count();
    }

    public function getTotalIncomeAttribute(): float
    {
        return $this->finances()->where('type', 'income')->sum('amount') ?? 0;
    }

    public function getTotalExpensesAttribute(): float
    {
        return $this->finances()->where('type', 'expense')->sum('amount') ?? 0;
    }

    public function getBalanceAttribute(): float
    {
        return $this->total_income - $this->total_expenses;
    }

    public function isRegistrationOpen(): bool
    {
        if (!$this->registration_required) {
            return false;
        }
        
        if ($this->registration_deadline && now() > $this->registration_deadline) {
            return false;
        }
        
        if ($this->max_participants && $this->total_registrations >= $this->max_participants) {
            return false;
        }
        
        return $this->status === 'registration_open' || $this->status === 'planned';
    }
}
