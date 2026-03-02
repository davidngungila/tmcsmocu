<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpersonationController extends Controller
{
    public function start(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $currentUser = Auth::user();

        if (!$currentUser) {
            abort(403);
        }

        if (($currentUser->role->slug ?? null) !== 'admin') {
            abort(403);
        }

        $targetUserId = (int) $request->input('user_id');
        $targetUser = User::findOrFail($targetUserId);

        $request->session()->put('impersonator_user_id', $currentUser->id);
        $request->session()->put('impersonate_user_id', $targetUser->id);
        $request->session()->forget('active_role_id');

        return back();
    }

    public function stop(Request $request)
    {
        $request->session()->forget(['impersonate_user_id', 'impersonator_user_id', 'active_role_id']);

        return back();
    }
}
