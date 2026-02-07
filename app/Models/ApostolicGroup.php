<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ApostolicGroup extends Model
{
    protected $fillable = [
        'name',
        'description',
        'leader_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function leader(): BelongsTo
    {
        return $this->belongsTo(Parishioner::class, 'leader_id');
    }

    public function parishioners(): BelongsToMany
    {
        return $this->belongsToMany(Parishioner::class, 'parishioner_apostolic_group')->withPivot('joined_date', 'is_active')->withTimestamps();
    }
}
