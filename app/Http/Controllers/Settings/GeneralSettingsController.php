<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors([
                'current_password' => 'The current password is incorrect.',
            ]);
        }

        $user->password = Hash::make($validated['password']);
        $user->save();

        return back()->with('success', 'Password updated successfully.');
    }
}
