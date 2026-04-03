<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        // Get all users and roles
        $users = User::all();
        $roles = Role::all();
        
        if ($users->isNotEmpty() && $roles->isNotEmpty()) {
            // Assign specific roles to specific users (not all roles to one user)
            $assignments = [
                'priest@church.com' => 'priest',      // Priest gets priest role
                'leader@church.com' => 'leader',     // Leader gets leader role
                'secretary@church.com' => 'secretary', // Secretary gets secretary role
                'treasurer@church.com' => 'treasurer', // Treasurer gets treasurer role
                'admin@church.com' => 'system_admin', // Admin gets admin role
            ];
            
            foreach ($assignments as $email => $roleSlug) {
                $user = $users->where('email', $email)->first();
                $role = $roles->where('slug', $roleSlug)->first();
                
                if ($user && $role) {
                    // Check if role already assigned
                    $existing = DB::table('user_roles')
                        ->where('user_id', $user->id)
                        ->where('role_id', $role->id)
                        ->exists();
                    
                    if (!$existing) {
                        DB::table('user_roles')->insert([
                            'user_id' => $user->id,
                            'role_id' => $role->id,
                            'is_active' => true,
                            'assigned_at' => now(),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
            
            $this->command->info('User roles seeded successfully.');
        } else {
            $this->command->info('No users or roles found to seed user roles.');
        }
    }
}
