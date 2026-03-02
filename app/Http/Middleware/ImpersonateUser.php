<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpersonateUser
{
    public function handle(Request $request, Closure $next)
    {
        $impersonateUserId = $request->session()->get('impersonate_user_id');
        $impersonatorId = $request->session()->get('impersonator_user_id');

        if ($impersonateUserId && $impersonatorId) {
            $user = User::find($impersonateUserId);

            if ($user) {
                Auth::setUser($user);
            } else {
                $request->session()->forget(['impersonate_user_id', 'impersonator_user_id', 'active_role_id']);
            }
        }

        return $next($request);
    }
}
