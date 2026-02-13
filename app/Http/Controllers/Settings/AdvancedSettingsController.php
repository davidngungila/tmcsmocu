<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class AdvancedSettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'chaplaincy_name' => SystemSetting::getValue('chaplaincy_name', 'St. Joseph Chaplaincy MoCU'),
            'chaplaincy_address' => SystemSetting::getValue('chaplaincy_address', 'S.L.P 123, Moshi'),
            'chaplaincy_phone' => SystemSetting::getValue('chaplaincy_phone', '+255 123 456 789'),
            'chaplaincy_email' => SystemSetting::getValue('chaplaincy_email', 'info@stjosephmocu.org'),
            'chaplaincy_website' => SystemSetting::getValue('chaplaincy_website', 'www.stjosephmocu.org'),
            'currency' => SystemSetting::getValue('currency', 'TZS'),
            'currency_symbol' => SystemSetting::getValue('currency_symbol', 'TZS'),
            'date_format' => SystemSetting::getValue('date_format', 'dd/mm/yyyy'),
            'time_format' => SystemSetting::getValue('time_format', '24hrs'),
            'timezone' => SystemSetting::getValue('timezone', 'Africa/Dar_es_Salaam'),
            'week_starts_on' => SystemSetting::getValue('week_starts_on', 'Sunday'),
            'system_language' => SystemSetting::getValue('system_language', 'Kiswahili'),
            'backup_frequency' => SystemSetting::getValue('backup_frequency', 'daily'),
            'backup_time' => SystemSetting::getValue('backup_time', '03:00'),
            'backup_storage' => SystemSetting::getValue('backup_storage', 'Local + Cloud'),
            'https_enabled' => SystemSetting::getValue('https_enabled', true),
            'two_factor_available' => SystemSetting::getValue('two_factor_available', true),
            'password_strength' => SystemSetting::getValue('password_strength', 'strong'),
            'max_login_attempts' => SystemSetting::getValue('max_login_attempts', 5),
            'lockout_time' => SystemSetting::getValue('lockout_time', 30),
        ];
        
        return view('settings.advanced.index', compact('settings'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'chaplaincy_name' => 'required|string|max:255',
            'chaplaincy_address' => 'nullable|string|max:500',
            'chaplaincy_phone' => 'nullable|string|max:20',
            'chaplaincy_email' => 'nullable|email|max:255',
            'chaplaincy_website' => 'nullable|string|max:255',
            'currency' => 'required|string|max:10',
            'currency_symbol' => 'required|string|max:10',
            'date_format' => 'required|string',
            'time_format' => 'required|string',
            'timezone' => 'required|string',
            'week_starts_on' => 'required|string',
            'system_language' => 'required|string',
            'backup_frequency' => 'required|string',
            'backup_time' => 'required|string',
            'backup_storage' => 'required|string',
            'https_enabled' => 'boolean',
            'two_factor_available' => 'boolean',
            'password_strength' => 'required|string',
            'max_login_attempts' => 'required|integer|min:3|max:10',
            'lockout_time' => 'required|integer|min:5|max:60',
        ]);
        
        foreach ($validated as $key => $value) {
            SystemSetting::setValue($key, $value, is_bool($value) ? 'boolean' : 'string');
        }
        
        return redirect()->route('settings.advanced.index')
            ->with('success', 'Mipangilio ya hali ya juu imehifadhiwa kwa mafanikio.');
    }
}

