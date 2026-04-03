<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    protected $fillable = [
        'region',
        'region_code',
        'district',
        'district_code',
        'ward',
        'ward_code',
        'street',
        'place',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByRegion($query, $regionCode)
    {
        return $query->where('region_code', $regionCode);
    }

    public function scopeByDistrict($query, $districtCode)
    {
        return $query->where('district_code', $districtCode);
    }

    public function scopeByWard($query, $wardCode)
    {
        return $query->where('ward_code', $wardCode);
    }

    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->place,
            $this->street,
            $this->ward,
            $this->district,
            $this->region,
        ]);

        return implode(', ', $parts);
    }

    public function getRegionNameAttribute(): string
    {
        $regions = [
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

        return $regions[$this->region_code] ?? $this->region_code;
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

    public static function getDistricts(): array
    {
        return [
            'AR01' => 'Arumeru',
            'AR02' => 'Arusha Rural',
            'AR03' => 'Karatu',
            'DS01' => 'Ilala',
            'DS02' => 'Kinondoni',
            'DS03' => 'Temeke',
            'DS04' => 'Ubungo',
            'DS05' => 'Kigamboni',
            // Add more districts as needed
        ];
    }
}
