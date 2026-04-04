<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewRolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all permissions
        $permissions = \DB::table('permissions')->get();
        
        // Get all roles
        $roles = \DB::table('roles')->get()->keyBy('name');
        
        // Define role permissions based on hierarchy and responsibilities
        $rolePermissions = [
            'super_admin' => $permissions->pluck('id')->toArray(), // All permissions
            
            'chaplain' => $permissions->filter(function($p) {
                return !in_array($p->name, [
                    'system.backup', 'system.restore', 'system.maintenance', 
                    'system.config', 'system.logs', 'system.security'
                ]);
            })->pluck('id')->toArray(),
            
            'chairperson_employee' => $permissions->filter(function($p) {
                return in_array($p->module, [
                    'members', 'finance', 'events', 'reports', 'communication_email', 'communication_sms'
                ]) || in_array($p->name, [
                    'users.view', 'roles.view', 'permissions.view'
                ]);
            })->pluck('id')->toArray(),
            
            'chairperson_student' => $permissions->filter(function($p) {
                return in_array($p->module, [
                    'members', 'events', 'spiritual_groups', 'reports', 'communication_email'
                ]) || in_array($p->name, [
                    'users.view', 'roles.view', 'permissions.view'
                ]);
            })->pluck('id')->toArray(),
            
            'secretary' => $permissions->filter(function($p) {
                return in_array($p->module, [
                    'members', 'certificates', 'events', 'reports', 'communication_email'
                ]) || in_array($p->name, [
                    'users.view', 'roles.view', 'permissions.view'
                ]);
            })->pluck('id')->toArray(),
            
            'treasurer' => $permissions->filter(function($p) {
                return in_array($p->module, ['finance', 'reports']) || 
                       in_array($p->name, [
                           'members.view', 'events.view', 'assets.view'
                       ]);
            })->pluck('id')->toArray(),
            
            'spiritual_coordinator' => $permissions->filter(function($p) {
                return in_array($p->module, ['spiritual_groups', 'events', 'members']) ||
                       in_array($p->name, [
                           'spiritual_groups.manage', 'spiritual_groups.view',
                           'events.manage', 'events.view',
                           'members.view', 'members.create', 'members.update'
                       ]);
            })->pluck('id')->toArray(),
            
            'community_leader' => $permissions->filter(function($p) {
                return in_array($p->module, ['communities', 'members']) ||
                       in_array($p->name, [
                           'communities.manage', 'communities.view',
                           'members.view', 'members.create', 'members.update'
                       ]);
            })->pluck('id')->toArray(),
            
            'group_leader' => $permissions->filter(function($p) {
                return in_array($p->module, ['spiritual_groups', 'members']) ||
                       in_array($p->name, [
                           'spiritual_groups.manage', 'spiritual_groups.view',
                           'members.view', 'members.create', 'members.update'
                       ]);
            })->pluck('id')->toArray(),
            
            'kamati_head' => $permissions->filter(function($p) {
                return in_array($p->module, ['events', 'assets', 'members']) ||
                       in_array($p->name, [
                           'events.manage', 'events.view',
                           'assets.manage', 'assets.view',
                           'members.view'
                       ]);
            })->pluck('id')->toArray(),
            
            'member' => $permissions->filter(function($p) {
                return in_array($p->name, [
                    'profile.view', 'profile.update',
                    'contributions.view', 'certificates.view',
                    'events.view', 'members.view'
                ]);
            })->pluck('id')->toArray(),
            
            'event_chairperson' => $permissions->filter(function($p) {
                return in_array($p->module, ['events']) ||
                       in_array($p->name, [
                           'events.manage', 'events.view', 'events.create', 'events.update',
                           'members.view', 'assets.view'
                       ]);
            })->pluck('id')->toArray(),
        ];
        
        // Assign permissions to roles
        foreach ($rolePermissions as $roleName => $permissionIds) {
            $role = $roles->get($roleName);
            if ($role) {
                foreach ($permissionIds as $permissionId) {
                    \DB::table('role_permissions')->insert([
                        'role_id' => $role->id,
                        'permission_id' => $permissionId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
        
        $this->command->info('New role permissions seeded successfully!');
    }
}
