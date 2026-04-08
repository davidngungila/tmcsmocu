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
        // Get admin user (ID: 5)
        $adminUserId = 5;
        
        // Get all role IDs
        $allRoleIds = \DB::table('roles')->pluck('id')->toArray();
        
        // Remove existing role assignments for admin to avoid duplicates
        \DB::table('user_roles')->where('user_id', $adminUserId)->delete();
        
        // Assign all roles to admin user
        foreach ($allRoleIds as $roleId) {
            \DB::table('user_roles')->insert([
                'user_id' => $adminUserId,
                'role_id' => $roleId,
                'is_active' => 1,
                'assigned_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        // Keep admin's primary role as Super Admin (ID: 7)
        \DB::table('users')
            ->where('id', $adminUserId)
            ->update(['role_id' => 7]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove all role assignments from admin user except Super Admin
        $adminUserId = 5;
        $superAdminRoleId = 7;
        
        // Delete all role assignments for admin
        \DB::table('user_roles')->where('user_id', $adminUserId)->delete();
        
        // Assign only Super Admin role back
        \DB::table('user_roles')->insert([
            'user_id' => $adminUserId,
            'role_id' => $superAdminRoleId,
            'is_active' => 1,
            'assigned_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Keep admin's primary role as Super Admin
        \DB::table('users')
            ->where('id', $adminUserId)
            ->update(['role_id' => $superAdminRoleId]);
    }
};
