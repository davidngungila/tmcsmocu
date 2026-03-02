<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Statistics
        $totalUsers = User::count();
        $activeUsers = User::whereNotNull('email_verified_at')->count();
        $adminUsers = User::whereHas('role', function($q) {
            $q->where('slug', 'admin');
        })->count();
        $recentUsers = User::where('created_at', '>=', now()->subDays(30))->count();
        
        // Query with filters
        $query = User::with('role');
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Role filter
        if ($request->filled('role')) {
            $query->whereHas('role', function($q) use ($request) {
                $q->where('slug', $request->get('role'));
            });
        }
        
        // Status filter
        if ($request->filled('status')) {
            if ($request->get('status') === 'verified') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->get('status') === 'unverified') {
                $query->whereNull('email_verified_at');
            }
        }
        
        $users = $query->latest()->paginate(20)->withQueryString();
        $roles = Role::all();
        
        return view('settings.users.index', compact(
            'users',
            'roles',
            'totalUsers',
            'activeUsers',
            'adminUsers',
            'recentUsers'
        ));
    }

    public function create()
    {
        $roles = Role::all();
        return view('settings.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required|array|min:1',
            'roles.*' => 'required|exists:roles,id',
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'email_verified_at' => now(),
            'role_id' => $validated['roles'][0],
        ];

        $user = User::create($userData);
        $user->roles()->sync($validated['roles']);

        return redirect()->route('settings.users.index')
            ->with('success', 'User created successfully.');
    }

    public function show($id)
    {
        $user = User::with('role')->findOrFail($id);
        
        // Get user activity statistics
        $eventsCreated = \App\Models\Event::where('created_by', $user->id)->count();
        $incomeTransactions = \App\Models\FinanceTransaction::where('created_by', $user->id)->where('type', 'income')->count();
        $expenseTransactions = \App\Models\FinanceTransaction::where('created_by', $user->id)->where('type', 'expense')->count();
        $smsCampaigns = \App\Models\SmsCampaign::where('created_by', $user->id)->count();
        $sacramentSales = \App\Models\SacramentSale::where('created_by', $user->id)->count();
        
        // Get recent activities
        $recentEvents = \App\Models\Event::where('created_by', $user->id)->latest()->limit(5)->get();
        $recentTransactions = \App\Models\FinanceTransaction::where('created_by', $user->id)->latest()->limit(5)->get();
        $recentSmsCampaigns = \App\Models\SmsCampaign::where('created_by', $user->id)->latest()->limit(5)->get();
        
        // Get role permissions
        $permissions = $user->role->permissions ?? [];
        
        return view('settings.users.show', compact(
            'user',
            'eventsCreated',
            'incomeTransactions',
            'expenseTransactions',
            'smsCampaigns',
            'sacramentSales',
            'recentEvents',
            'recentTransactions',
            'recentSmsCampaigns',
            'permissions'
        ));
    }

    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();
        return view('settings.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'required|array|min:1',
            'roles.*' => 'required|exists:roles,id',
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role_id' => $validated['roles'][0],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);
        $user->roles()->sync($validated['roles']);

        return redirect()->route('settings.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('settings.users.index')
                ->with('error', 'You cannot delete your own account.');
        }
        
        $user->delete();

        return redirect()->route('settings.users.index')
            ->with('success', 'User deleted successfully.');
    }
}
