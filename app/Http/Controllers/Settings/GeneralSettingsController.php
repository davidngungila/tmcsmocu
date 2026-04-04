<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountSettingsUpdated;
use PragmaRX\Google2FA\Google2FA;

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
        $user = Auth::user();
        $user->load(['activityLogs' => function($query) {
            return $query->latest()->limit(5);
        }]);
        
        return view('settings.general.account', compact('user'));
    }
    
    public function updateAccount(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            abort(403);
        }

        $validated = $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:1000',
            'location' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
            'language' => 'nullable|in:en,sw',
            'timezone' => 'nullable|string',
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
            'profile_visibility' => 'nullable|in:public,private,friends_only',
        ]);

        $user->update($validated);

        // Log activity
        $this->logActivity('Account settings updated', 'User updated their account settings');

        return back()->with('success', 'Account settings updated successfully.');
    }
    
    public function security()
    {
        $user = Auth::user();
        $sessions = $this->getActiveSessions($user);
        
        return view('settings.general.security', compact('user', 'sessions'));
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

        // Log activity
        $this->logActivity('Password changed', 'User changed their password');

        // Send email notification
        try {
            Mail::to($user->email)->send(new AccountSettingsUpdated($user, 'Password Changed'));
        } catch (\Exception $e) {
            \Log::error('Failed to send password change email: ' . $e->getMessage());
        }

        return back()->with('success', 'Password updated successfully.');
    }
    
    public function updateEmail(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            abort(403);
        }

        $validated = $request->validate([
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'required|string',
        ]);

        if (!Hash::check($validated['password'], $user->password)) {
            return back()->withErrors([
                'password' => 'The password is incorrect.',
            ]);
        }

        $user->email = $validated['email'];
        $user->email_verified_at = null;
        $user->save();

        $this->logActivity('Email updated', 'User changed their email address');

        return back()->with('success', 'Email updated successfully. Please verify your new email address.');
    }
    
    public function enableTwoFactor()
    {
        $user = Auth::user();
        
        if (!$user) {
            abort(403);
        }

        // Generate 2FA secret and backup codes
        $google2fa = new Google2FA();
        $secret = $google2fa->generateSecretKey();
        $qrCodeUrl = $google2fa->getQRCodeGoogleUrl('TmcsSmart', $user->email, $secret);
        
        $user->update([
            'google2fa_secret' => encrypt($secret),
            'google2fa_enabled' => false,
            'google2fa_backup_codes' => json_encode($this->generateBackupCodes()),
        ]);

        return view('settings.general.two-factor-setup', compact('secret', 'qrCodeUrl'));
    }
    
    public function verifyTwoFactor(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            abort(403);
        }

        $request->validate([
            'code' => 'required|string|digits:6',
        ]);

        $google2fa = new Google2FA();
        $secret = decrypt($user->google2fa_secret);
        
        if ($google2fa->verifyKey($user->email, $secret, $request->code)) {
            $user->update(['google2fa_enabled' => true]);
            
            $this->logActivity('2FA enabled', 'User enabled two-factor authentication');
            
            return redirect()->route('settings.security')
                ->with('success', 'Two-factor authentication enabled successfully.');
        }

        return back()->withErrors(['code' => 'Invalid verification code.']);
    }
    
    public function disableTwoFactor(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            abort(403);
        }

        $request->validate([
            'password' => 'required|string',
        ]);

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'The password is incorrect.']);
        }

        $user->update([
            'google2fa_secret' => null,
            'google2fa_enabled' => false,
            'google2fa_backup_codes' => null,
        ]);

        $this->logActivity('2FA disabled', 'User disabled two-factor authentication');

        return redirect()->route('settings.security')
            ->with('success', 'Two-factor authentication disabled successfully.');
    }
    
    private function getActiveSessions($user)
    {
        // This would typically use Laravel's session management
        // For now, return mock data
        return [
            [
                'id' => 'current',
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'last_activity' => now(),
                'is_current' => true,
            ]
        ];
    }
    
    private function generateBackupCodes()
    {
        $codes = [];
        for ($i = 0; $i < 8; $i++) {
            $codes[] = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        }
        return $codes;
    }
    
    private function logActivity($action, $description)
    {
        $user = Auth::user();
        if ($user) {
            $user->activityLogs()->create([
                'action' => $action,
                'description' => $description,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        }
    }
}
