<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplyActiveRole
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user) {
            $availableRoles = $user->availableRoles();
            $activeRoleId = $request->session()->get('active_role_id');

            $activeRole = $activeRoleId ? $availableRoles->firstWhere('id', $activeRoleId) : null;
            $activeRole = $activeRole ?: ($user->role ?? $availableRoles->first());

            if ($activeRole) {
                $user->setRelation('role', $activeRole);
            }
        }

        return $next($request);
    }
}
