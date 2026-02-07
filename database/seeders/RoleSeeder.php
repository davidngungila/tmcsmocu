<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Padri',
                'slug' => 'padri',
                'description' => 'Padri / Baba wa Kanisa - Full access to all features',
                'permissions' => ['*'], // All permissions
            ],
            [
                'name' => 'Viongozi',
                'slug' => 'viongozi',
                'description' => 'Viongozi wa Chaptance - Limited administrative access',
                'permissions' => ['view_reports', 'manage_events', 'view_parishioners'],
            ],
            [
                'name' => 'Katibu',
                'slug' => 'katibu',
                'description' => 'Katibu - Secretary with data entry and management access',
                'permissions' => ['create_parishioners', 'create_events', 'create_sms'],
            ],
            [
                'name' => 'Mweka Hazina',
                'slug' => 'mweka_hazina',
                'description' => 'Mweka Hazina - Treasurer with finance management access',
                'permissions' => ['manage_finance', 'view_reports', 'approve_sms'],
            ],
            [
                'name' => 'System Admin',
                'slug' => 'system_admin',
                'description' => 'System Administrator - Full system access',
                'permissions' => ['*'], // All permissions
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
