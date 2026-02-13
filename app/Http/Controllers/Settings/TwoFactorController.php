<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TwoFactorController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('settings.two-factor.index', compact('user'));
    }
    
    public function enable(Request $request)
    {
        $user = Auth::user();
        
        // Generate a secret (in production, use proper TOTP secret generation)
        $secret = Str::random(32);
        
        // Generate recovery codes
        $recoveryCodes = [];
        for ($i = 0; $i < 8; $i++) {
            $recoveryCodes[] = strtoupper(Str::random(8));
        }
        
        $user->update([
            'two_factor_enabled' => true,
            'two_factor_secret' => $secret,
            'two_factor_recovery_codes' => json_encode($recoveryCodes),
            'two_factor_confirmed_at' => now(),
        ]);
        
        return redirect()->route('settings.two-factor.index')
            ->with('success', '2FA imewezeshwa kwa mafanikio.')
            ->with('recovery_codes', $recoveryCodes);
    }
    
    public function disable(Request $request)
    {
        $request->validate([
            'password' => 'required|current_password',
        ]);
        
        $user = Auth::user();
        
        $user->update([
            'two_factor_enabled' => false,
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ]);
        
        return redirect()->route('settings.two-factor.index')
            ->with('success', '2FA imezuiwa kwa mafanikio.');
    }
    
    public function regenerateRecoveryCodes(Request $request)
    {
        $user = Auth::user();
        
        $recoveryCodes = [];
        for ($i = 0; $i < 8; $i++) {
            $recoveryCodes[] = strtoupper(Str::random(8));
        }
        
        $user->update([
            'two_factor_recovery_codes' => json_encode($recoveryCodes),
        ]);
        
        return redirect()->route('settings.two-factor.index')
            ->with('success', 'Nambari za uokoaji zimetengenezwa upya.')
            ->with('recovery_codes', $recoveryCodes);
    }
}

