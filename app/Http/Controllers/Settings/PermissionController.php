<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('users')->latest()->get();
        
        // Available permissions list
        $availablePermissions = [
            'finance' => [
                'view_finance' => 'View Finance',
                'manage_income' => 'Manage Income',
                'manage_expenses' => 'Manage Expenses',
                'view_reports' => 'View Reports',
                'manage_sacraments' => 'Manage Sacraments',
            ],
            'parishioners' => [
                'view_parishioners' => 'View Parishioners',
                'create_parishioners' => 'Create Parishioners',
                'edit_parishioners' => 'Edit Parishioners',
                'delete_parishioners' => 'Delete Parishioners',
            ],
            'communities' => [
                'view_communities' => 'View Communities',
                'manage_communities' => 'Manage Communities',
            ],
            'groups' => [
                'view_groups' => 'View Groups',
                'manage_groups' => 'Manage Groups',
            ],
            'events' => [
                'view_events' => 'View Events',
                'manage_events' => 'Manage Events',
            ],
            'leaders' => [
                'view_leaders' => 'View Leaders',
                'manage_leaders' => 'Manage Leaders',
            ],
            'assets' => [
                'view_assets' => 'View Assets',
                'manage_assets' => 'Manage Assets',
            ],
            'sms' => [
                'view_sms' => 'View SMS',
                'create_sms' => 'Create SMS',
                'approve_sms' => 'Approve SMS',
                'view_sms_reports' => 'View SMS Reports',
            ],
            'settings' => [
                'view_settings' => 'View Settings',
                'manage_users' => 'Manage Users',
                'manage_roles' => 'Manage Roles',
                'manage_settings' => 'Manage System Settings',
            ],
        ];
        
        return view('settings.permissions.index', compact('roles', 'availablePermissions'));
    }
    
    public function updatePermissions(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        
        $validated = $request->validate([
            'permissions' => 'nullable|array',
        ]);
        
        $role->update([
            'permissions' => $validated['permissions'] ?? []
        ]);
        
        return redirect()->route('settings.permissions.index')
            ->with('success', 'Permissions updated successfully.');
    }
}
