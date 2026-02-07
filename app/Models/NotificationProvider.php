<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationProvider extends Model
{
    protected $fillable = [
        'name',
        'type',
        'is_primary',
        'is_active',
        'sms_username',
        'sms_password',
        'sms_from',
        'sms_url',
        'mail_host',
        'mail_port',
        'mail_username',
        'mail_password',
        'mail_encryption',
        'mail_from_address',
        'mail_from_name',
        'description',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'is_active' => 'boolean',
        'mail_port' => 'integer',
    ];

    /**
     * Get primary provider for a type
     */
    public static function getPrimary(string $type)
    {
        return self::where('type', $type)
            ->where('is_primary', true)
            ->where('is_active', true)
            ->first();
    }

    /**
     * Get all active providers for a type
     */
    public static function getActive(string $type)
    {
        return self::where('type', $type)
            ->where('is_active', true)
            ->orderBy('is_primary', 'desc')
            ->orderBy('name')
            ->get();
    }

    /**
     * Set as primary provider
     */
    public function setAsPrimary()
    {
        // Remove primary from other providers of same type
        self::where('type', $this->type)
            ->where('id', '!=', $this->id)
            ->update(['is_primary' => false]);

        $this->update(['is_primary' => true]);
    }
}
