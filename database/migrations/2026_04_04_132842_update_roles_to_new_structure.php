<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Clear existing roles and create new structure
        \DB::table('roles')->delete();
        \DB::table('role_permissions')->delete();
        
        $roles = [
            ['name' => 'super_admin', 'display_name' => 'Super Admin', 'level' => 1, 'is_active' => true, 'responsibilities' => 'Full system control (similar to your "System Admin")'],
            ['name' => 'chaplain', 'display_name' => 'Chaplain', 'level' => 2, 'is_active' => true, 'responsibilities' => 'Full access except system configuration (rename "Priest" to "Chaplain")'],
            ['name' => 'chairperson_employee', 'display_name' => 'Chairperson (Employee)', 'level' => 3, 'is_active' => true, 'responsibilities' => 'Co-leadership, oversees employee affairs'],
            ['name' => 'chairperson_student', 'display_name' => 'Chairperson (Student)', 'level' => 3, 'is_active' => true, 'responsibilities' => 'Co-leadership, oversees student operations'],
            ['name' => 'secretary', 'display_name' => 'Secretary', 'level' => 4, 'is_active' => true, 'responsibilities' => 'Records, correspondence, data entry'],
            ['name' => 'treasurer', 'display_name' => 'Treasurer', 'level' => 4, 'is_active' => true, 'responsibilities' => 'Full financial management'],
            ['name' => 'spiritual_coordinator', 'display_name' => 'Spiritual Coordinator', 'level' => 5, 'is_active' => true, 'responsibilities' => 'Manages own academic programme only'],
            ['name' => 'community_leader', 'display_name' => 'Community Leader', 'level' => 5, 'is_active' => true, 'responsibilities' => 'Manages own community only'],
            ['name' => 'group_leader', 'display_name' => 'Group Leader', 'level' => 5, 'is_active' => true, 'responsibilities' => 'Manages own spiritual group only'],
            ['name' => 'kamati_head', 'display_name' => 'Kamati Head', 'level' => 6, 'is_active' => true, 'responsibilities' => 'Manages own committee (Liturgical, Decoration, Table of Sales)'],
            ['name' => 'member', 'display_name' => 'Member', 'level' => 7, 'is_active' => true, 'responsibilities' => 'Self-service (view own profile, contributions, certificates, events)'],
            ['name' => 'event_chairperson', 'display_name' => 'Event Chairperson', 'level' => 8, 'is_active' => true, 'responsibilities' => 'Temporary role for a specific event'],
        ];
        
        foreach ($roles as $role) {
            $roleId = \DB::table('roles')->insertGetId([
                'name' => $role['name'],
                'display_name' => $role['display_name'],
                'slug' => str_replace(' ', '_', strtolower($role['display_name'])),
                'description' => $role['responsibilities'],
                'level' => $role['level'],
                'is_active' => $role['is_active'],
                'responsibilities' => $role['responsibilities'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore original roles
        \DB::table('roles')->delete();
        \DB::table('role_permissions')->delete();
        
        $originalRoles = [
            ['name' => 'super_admin', 'display_name' => 'Super Admin', 'level' => 1, 'is_active' => true, 'responsibilities' => 'Full system access'],
            ['name' => 'priest', 'display_name' => 'Priest', 'level' => 2, 'is_active' => true, 'responsibilities' => 'Religious leadership'],
            ['name' => 'church_leader', 'display_name' => 'Church Leader', 'level' => 3, 'is_active' => true, 'responsibilities' => 'Church management'],
            ['name' => 'secretary', 'display_name' => 'Secretary', 'level' => 4, 'is_active' => true, 'responsibilities' => 'Administrative tasks'],
            ['name' => 'treasurer', 'display_name' => 'Treasurer', 'level' => 4, 'is_active' => true, 'responsibilities' => 'Financial management'],
            ['name' => 'system_admin', 'display_name' => 'System Admin', 'level' => 1, 'is_active' => true, 'responsibilities' => 'System configuration'],
        ];
        
        foreach ($originalRoles as $role) {
            \DB::table('roles')->insert([
                'name' => $role['name'],
                'display_name' => $role['display_name'],
                'slug' => str_replace(' ', '_', strtolower($role['display_name'])),
                'description' => $role['responsibilities'],
                'level' => $role['level'],
                'is_active' => $role['is_active'],
                'responsibilities' => $role['responsibilities'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
};
