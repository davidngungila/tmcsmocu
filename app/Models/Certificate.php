<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    protected $fillable = [
        'certificate_number',
        'type',
        'recipient_name',
        'group_name',
        'description',
        'issue_date',
        'template_name',
        'file_path',
        'verification_code',
        'is_verified',
        'status',
        'revoked_at',
        'revoked_by',
        'issued_by',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'is_verified' => 'boolean',
        'revoked_at' => 'datetime',
    ];

    public function issuedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    public function revokedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'revoked_by');
    }

    public static function generateCertificateNumber(): string
    {
        $prefix = 'CERT';
        $year = date('Y');
        $sequence = static::whereYear('created_at', $year)->count() + 1;
        
        return sprintf('%s-%s-%04d', $prefix, $year, $sequence);
    }

    public static function generateVerificationCode(): string
    {
        return strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 12));
    }
}
