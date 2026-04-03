<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SpiritualGroup extends Model
{
    protected $fillable = [
        'name',
        'type',
        'description',
        'chairperson_name',
        'chairperson_email',
        'chairperson_phone',
        'deputy_chairperson_name',
        'deputy_chairperson_email',
        'deputy_chairperson_phone',
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

    public function parishioners(): BelongsToMany
    {
        return $this->belongsToMany(Parishioner::class, 'parishioner_spiritual_group')
            ->withPivot('role', 'joined_at')
            ->withTimestamps();
    }

    public function leaders(): BelongsToMany
    {
        return $this->parishioners()->wherePivot('role', 'leader');
    }

    public function members(): BelongsToMany
    {
        return $this->parishioners()->wherePivot('role', 'member');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function getMemberCountAttribute(): int
    {
        return $this->members()->count();
    }

    public function getLeaderCountAttribute(): int
    {
        return $this->leaders()->count();
    }

    public function getTotalMembersAttribute(): int
    {
        return $this->parishioners()->count();
    }

    public static function getTypes(): array
    {
        return [
            'choir' => 'Choir',
            'legion' => 'Legion of Mary',
            'charismatic' => 'Charismatic Renewal',
            'altar' => 'Altar Servers',
            'readers' => 'Readers',
            'ushers' => 'Ushers',
            'media' => 'Media Team',
            'youth' => 'Youth Ministry',
            'catechism' => 'Catechism',
            'other' => 'Other',
        ];
    }
}
