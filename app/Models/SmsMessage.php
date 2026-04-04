<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SmsMessage extends Model
{
    use HasFactory;

    const TYPE_SINGLE = 'single';
    const TYPE_BROADCAST = 'broadcast';
    const TYPE_SCHEDULED = 'scheduled';

    const STATUS_PENDING = 'pending';
    const STATUS_SENT = 'sent';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_FAILED = 'failed';
    const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'type',
        'sender_id',
        'recipient',
        'message',
        'scheduled_at',
        'sent_at',
        'delivered_at',
        'status',
        'message_id',
        'reference',
        'cost',
        'sms_count',
        'error_message',
        'sent_by',
        'notes',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
        'delivered_at' => 'datetime',
        'cost' => 'decimal:2',
        'sms_count' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'sent_by');
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            self::STATUS_SENT => 'blue',
            self::STATUS_DELIVERED => 'green',
            self::STATUS_FAILED => 'red',
            self::STATUS_CANCELLED => 'orange',
            self::STATUS_PENDING => 'yellow',
            default => 'gray',
        };
    }

    public function getTypeColorAttribute()
    {
        return match($this->type) {
            self::TYPE_SINGLE => 'blue',
            self::TYPE_BROADCAST => 'purple',
            self::TYPE_SCHEDULED => 'orange',
            default => 'gray',
        };
    }

    public function getFormattedCostAttribute()
    {
        return number_format($this->cost, 2, '.', ',');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeSent($query)
    {
        return $query->where('status', self::STATUS_SENT);
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', self::STATUS_DELIVERED);
    }

    public function scopeFailed($query)
    {
        return $query->where('status', self::STATUS_FAILED);
    }

    public function scopeScheduled($query)
    {
        return $query->where('type', self::TYPE_SCHEDULED)
                    ->where('status', self::STATUS_PENDING);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }
}
