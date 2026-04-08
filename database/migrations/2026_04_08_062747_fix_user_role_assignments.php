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
        // Map users to appropriate roles based on their email/position
        $userRoleMappings = [
            // System Administrator -> Super Admin
            5 => 7,  // admin@church.com -> super_admin (ID: 7)
            
            // Father John Smith (priest@church.com) -> Chaplain
            1 => 8,  // priest@church.com -> chaplain (ID: 8)
            
            // Michael Johnson (leader@church.com) -> Chairperson (Employee)
            2 => 9,  // leader@church.com -> chairperson_employee (ID: 9)
            
            // Sarah Williams (secretary@church.com) -> Secretary
            3 => 11, // secretary@church.com -> secretary (ID: 11)
            
            // David Brown (treasurer@church.com) -> Treasurer
            4 => 12, // treasurer@church.com -> treasurer (ID: 12)
        ];
        
        // Update users with their new role_id
        foreach ($userRoleMappings as $userId => $roleId) {
            \DB::table('users')
                ->where('id', $userId)
                ->update(['role_id' => $roleId]);
        }
        
        // Also create entries in user_roles table for the many-to-many relationship
        foreach ($userRoleMappings as $userId => $roleId) {
            \DB::table('user_roles')->insert([
                'user_id' => $userId,
                'role_id' => $roleId,
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
        // Remove role_id from users and user_roles entries
        $affectedUserIds = [1, 2, 3, 4, 5];
        
        // Set role_id to null for affected users
        \DB::table('users')
            ->whereIn('id', $affectedUserIds)
            ->update(['role_id' => null]);
        
        // Remove entries from user_roles table
        \DB::table('user_roles')
            ->whereIn('user_id', $affectedUserIds)
            ->delete();
    }
};
