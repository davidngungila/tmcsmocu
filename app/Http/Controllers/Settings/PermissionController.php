<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('users', 'permissions')->active()->latest()->get();
        $modulesCount = Permission::distinct('module')->count('module');
        
        return view('settings.permissions.index', compact('roles', 'modulesCount'));
    }
    
    public function edit($id)
    {
        $role = Role::with(['permissions', 'users'])->findOrFail($id);
        $allPermissions = Permission::orderBy('module')->orderBy('category')->orderBy('display_name')->get();
        $rolePermissions = $role->permissions;
        
        // Group permissions by module
        $modulePermissions = $allPermissions->groupBy('module');
        
        return view('settings.permissions.edit', compact('role', 'modulePermissions', 'rolePermissions', 'allPermissions'));
    }
    
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        
        $validated = $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);
        
        $permissionIds = $validated['permissions'] ?? [];
        
        // Sync permissions
        $role->permissions()->sync($permissionIds);
        
        $displayName = $role->display_name ?? $role->name;
        return redirect()->route('settings.permissions.index')
            ->with('success', "Permissions updated for {$displayName} successfully.");
    }
    
    public function show($id)
    {
        $role = Role::with(['permissions' => function($query) {
            $query->orderBy('module')->orderBy('category')->orderBy('display_name');
        }])->findOrFail($id);
        
        $groupedPermissions = $role->permissions->groupBy('module');
        
        return view('settings.permissions.show', compact('role', 'groupedPermissions'));
    }
    
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        
        // Prevent deletion of roles with users
        if ($role->users()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete role that has assigned users.'
            ]);
        }
        
        $roleName = $role->display_name ?? $role->name;
        $role->delete();
        
        return response()->json([
            'success' => true,
            'message' => "Role '{$roleName}' deleted successfully."
        ]);
    }
    
    public function toggleStatus($id)
    {
        $role = Role::findOrFail($id);
        $role->is_active = !$role->is_active;
        $role->save();
        
        $status = $role->is_active ? 'activated' : 'deactivated';
        $roleName = $role->display_name ?? $role->name;
        
        return response()->json([
            'success' => true,
            'message' => "Role '{$roleName}' {$status} successfully."
        ]);
    }
    
    public function clone($id)
    {
        $role = Role::findOrFail($id);
        
        // Create new role with cloned data
        $newRole = $role->replicate();
        $newRole->name = $role->name . ' (Clone)';
        $newRole->slug = $role->slug . '_clone_' . time();
        $originalDisplayName = $role->display_name ?? $role->name;
        $newRole->display_name = $originalDisplayName . ' (Clone)';
        $newRole->is_active = false; // Start as inactive
        $newRole->save();
        
        // Clone permissions
        $permissionIds = $role->permissions->pluck('id')->toArray();
        $newRole->permissions()->attach($permissionIds);
        
        $roleDisplayName = $role->display_name ?? $role->name;
        return response()->json([
            'success' => true,
            'message' => "Role '{$roleDisplayName}' cloned successfully."
        ]);
    }
    
    public function bulkActivate(Request $request)
    {
        $roleIds = $request->input('role_ids', []);
        
        if (empty($roleIds)) {
            return response()->json([
                'success' => false,
                'message' => 'No roles selected.'
            ]);
        }
        
        $updated = Role::whereIn('id', $roleIds)->update(['is_active' => true]);
        
        return response()->json([
            'success' => true,
            'message' => "{$updated} role(s) activated successfully."
        ]);
    }
    
    public function bulkDeactivate(Request $request)
    {
        $roleIds = $request->input('role_ids', []);
        
        if (empty($roleIds)) {
            return response()->json([
                'success' => false,
                'message' => 'No roles selected.'
            ]);
        }
        
        $updated = Role::whereIn('id', $roleIds)->update(['is_active' => false]);
        
        return response()->json([
            'success' => true,
            'message' => "{$updated} role(s) deactivated successfully."
        ]);
    }
    
    public function bulkDelete(Request $request)
    {
        $roleIds = $request->input('role_ids', []);
        
        if (empty($roleIds)) {
            return response()->json([
                'success' => false,
                'message' => 'No roles selected.'
            ]);
        }
        
        // Check for roles with users
        $rolesWithUsers = Role::whereIn('id', $roleIds)->withCount('users')
            ->where('users_count', '>', 0)
            ->pluck('name');
            
        if ($rolesWithUsers->isNotEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete roles with assigned users: ' . $rolesWithUsers->join(', ')
            ]);
        }
        
        $deleted = Role::whereIn('id', $roleIds)->delete();
        
        return response()->json([
            'success' => true,
            'message' => "{$deleted} role(s) deleted successfully."
        ]);
    }
    
    public function exportPermissions()
    {
        $roles = Role::with('permissions')->get();
        $exportData = [];
        
        foreach ($roles as $role) {
            $exportData[] = [
                'name' => $role->name,
                'display_name' => $role->display_name ?? $role->name,
                'slug' => $role->slug,
                'level' => $role->level,
                'is_active' => $role->is_active ? 'Yes' : 'No',
                'users_count' => $role->users()->count(),
                'permissions_count' => $role->permissions->count(),
                'permissions' => $role->permissions->pluck('name')->implode(', ')
            ];
        }
        
        return response()->json($exportData);
    }
    
    public function importPermissions(Request $request)
    {
        // Implementation for importing permissions
        return response()->json([
            'success' => false,
            'message' => 'Import functionality will be implemented in the next version.'
        ]);
    }
}
