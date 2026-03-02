<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleSwitchController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'role_id' => 'required|integer',
        ]);

        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

        $roleId = (int) $request->input('role_id');
        $availableRoleIds = $user->availableRoles()->pluck('id')->all();

        if (!in_array($roleId, $availableRoleIds, true)) {
            abort(403);
        }

        $request->session()->put('active_role_id', $roleId);

        return back();
    }
}
