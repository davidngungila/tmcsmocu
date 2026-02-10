<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FinancialYear extends Model
{
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'is_active',
        'is_closed',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'is_closed' => 'boolean',
    ];

    /**
     * Get all finance transactions for this financial year
     */
    public function financeTransactions(): HasMany
    {
        return $this->hasMany(FinanceTransaction::class);
    }

    /**
     * Get all parishioners for this financial year
     */
    public function parishioners(): BelongsToMany
    {
        return $this->belongsToMany(Parishioner::class, 'parishioner_financial_years')
            ->withPivot('status', 'joined_date', 'graduated_date', 'notes')
            ->withTimestamps();
    }

    /**
     * Get active financial year
     */
    public static function getActive(): ?self
    {
        return self::where('is_active', true)->first();
    }

    /**
     * Set this financial year as active
     */
    public function setActive(): void
    {
        // Deactivate all other years
        self::where('id', '!=', $this->id)->update(['is_active' => false]);
        // Activate this year
        $this->update(['is_active' => true]);
    }

    /**
     * Close this financial year
     */
    public function close(): void
    {
        $this->update(['is_closed' => true, 'is_active' => false]);
    }
}
