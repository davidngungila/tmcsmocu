<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $user = Auth::user();
            
            // Check if 2FA is enabled
            if ($user->two_factor_enabled && $user->two_factor_secret) {
                // Store credentials in session for 2FA verification
                $request->session()->put('2fa_email', $request->email);
                $request->session()->put('2fa_password', $request->password);
                $request->session()->put('2fa_remember', $request->filled('remember'));
                $request->session()->put('2fa_user_id', $user->id);
                
                // Logout temporarily
                Auth::logout();
                $request->session()->regenerate();
                
                return redirect()->route('login')->with('2fa_required', true);
            }
            
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        throw ValidationException::withMessages([
            'email' => ['Hati zilizotolewa hazifanani na rekodi zetu.'],
        ]);
    }
    
    public function verify2FA(Request $request)
    {
        $request->validate([
            'code' => 'nullable|string|max:20',
            'email' => 'required|email',
            'password' => 'required',
            'skip_2fa' => 'nullable|boolean',
        ]);
        
        $email = $request->session()->get('2fa_email');
        $password = $request->session()->get('2fa_password');
        $remember = $request->session()->get('2fa_remember', false);
        $userId = $request->session()->get('2fa_user_id');
        
        if (!$email || !$password || !$userId) {
            return redirect()->route('login')->with('error', 'Sesi imeisha. Tafadhali ingia tena.');
        }
        
        $user = \App\Models\User::find($userId);
        
        if (!$user || $user->email !== $email) {
            return redirect()->route('login')->with('error', 'Mtumiaji huyu haupatikani.');
        }
        
        // Allow bypass if skip_2fa is checked
        if ($request->has('skip_2fa') && $request->skip_2fa) {
            // Verify password again for security
            if (!Auth::validate(['email' => $email, 'password' => $password])) {
                return redirect()->route('login')->with('error', 'Nenosiri si sahihi.');
            }
            
            // Clear 2FA session data
            $request->session()->forget(['2fa_email', '2fa_password', '2fa_remember', '2fa_user_id']);
            
            // Login the user
            Auth::login($user, $remember);
            $request->session()->regenerate();
            
            return redirect()->intended(route('dashboard'))
                ->with('warning', 'Umeingia bila 2FA. Tafadhali hakikisha simu yako iko karibu kwa usalama.');
        }
        
        // Verify 2FA code if provided
        if ($request->filled('code')) {
            $isValid = $this->verify2FACode($user, $request->code);
            
            if (!$isValid) {
                return redirect()->route('login')
                    ->with('2fa_required', true)
                    ->with('error', 'Msimbo wa 2FA si sahihi. Tafadhali jaribu tena au tumia nambari za uokoaji.');
            }
        } else {
            return redirect()->route('login')
                ->with('2fa_required', true)
                ->with('error', 'Tafadhali ingiza msimbo wa 2FA au chagua kuvuka 2FA.');
        }
        
        // Clear 2FA session data
        $request->session()->forget(['2fa_email', '2fa_password', '2fa_remember', '2fa_user_id']);
        
        // Login the user
        Auth::login($user, $remember);
        $request->session()->regenerate();
        
        return redirect()->intended(route('dashboard'));
    }
    
    public function bypass2FA(Request $request)
    {
        $email = $request->session()->get('2fa_email');
        $password = $request->session()->get('2fa_password');
        $remember = $request->session()->get('2fa_remember', false);
        $userId = $request->session()->get('2fa_user_id');
        
        if (!$email || !$password || !$userId) {
            return redirect()->route('login')->with('error', 'Sesi imeisha. Tafadhali ingia tena.');
        }
        
        $user = \App\Models\User::find($userId);
        
        if (!$user || $user->email !== $email) {
            return redirect()->route('login')->with('error', 'Mtumiaji huyu haupatikani.');
        }
        
        // Verify password again for security
        if (!Auth::validate(['email' => $email, 'password' => $password])) {
            return redirect()->route('login')->with('error', 'Nenosiri si sahihi.');
        }
        
        // Clear 2FA session data
        $request->session()->forget(['2fa_email', '2fa_password', '2fa_remember', '2fa_user_id']);
        
        // Login the user
        Auth::login($user, $remember);
        $request->session()->regenerate();
        
        return redirect()->intended(route('dashboard'))
            ->with('warning', 'Umeingia bila 2FA. Tafadhali hakikisha simu yako iko karibu kwa usalama.');
    }
    
    private function verify2FACode($user, $code)
    {
        // Simple time-based verification (can be enhanced with proper TOTP library)
        // For now, we'll use a simple secret-based verification
        if (!$user->two_factor_secret) {
            return false;
        }
        
        // In production, use a proper TOTP library like pragmarx/google2fa
        // For now, simple verification against stored secret
        $expectedCode = substr(md5($user->two_factor_secret . now()->format('Y-m-d-H-i')), 0, 6);
        
        // Also check recovery codes (can be 8 characters)
        $recoveryCodes = json_decode($user->two_factor_recovery_codes ?? '[]', true);
        if (in_array(strtoupper($code), array_map('strtoupper', $recoveryCodes))) {
            // Remove used recovery code
            $recoveryCodes = array_diff($recoveryCodes, [strtoupper($code)]);
            $user->update(['two_factor_recovery_codes' => json_encode(array_values($recoveryCodes))]);
            return true;
        }
        
        return $code === $expectedCode || $code === substr($user->two_factor_secret, 0, 6);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}

