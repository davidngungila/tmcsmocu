<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class GeneralSettingsController extends Controller
{
    public function index()
    {
        // Get all system settings grouped by category
        $settings = SystemSetting::orderBy('key')->get()->groupBy(function($setting) {
            // Group by prefix (e.g., 'app_', 'sms_', 'mail_')
            $parts = explode('_', $setting->key);
            return $parts[0] ?? 'general';
        });
        
        // Common settings keys
        $commonSettings = [
            'app_name' => SystemSetting::getValue('app_name', 'TmcsSmart'),
            'app_timezone' => SystemSetting::getValue('app_timezone', 'Africa/Dar_es_Salaam'),
            'app_locale' => SystemSetting::getValue('app_locale', 'sw'),
            'app_currency' => SystemSetting::getValue('app_currency', 'TZS'),
        ];
        
        return view('settings.general.index', compact('settings', 'commonSettings'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.*.key' => 'required|string',
            'settings.*.value' => 'nullable',
            'settings.*.type' => 'required|in:string,integer,boolean,json',
            'settings.*.description' => 'nullable|string',
        ]);
        
        foreach ($validated['settings'] as $setting) {
            SystemSetting::setValue(
                $setting['key'],
                $setting['value'],
                $setting['type'],
                $setting['description'] ?? null
            );
        }
        
        return redirect()->route('settings.general')
            ->with('success', 'Settings updated successfully.');
    }
    
    public function account()
    {
        return view('settings.general.account');
    }
    
    public function security()
    {
        return view('settings.general.security');
    }
}
