<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Permission extends Model
{
    protected $fillable = [
        'name',
        'display_name',
        'module',
        'category',
        'description',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }

    public static function getModulePermissions(string $module): array
    {
        return self::where('module', $module)->get()->groupBy('category')->toArray();
    }

    public static function getAvailableModules(): array
    {
        return self::distinct('module')->pluck('module')->sort()->toArray();
    }
}
