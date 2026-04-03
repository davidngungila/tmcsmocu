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
                'name' => 'Priest',
                'slug' => 'priest',
                'description' => 'Priest / Church Father - Full access to all features',
                'permissions' => ['*'], // All permissions
            ],
            [
                'name' => 'Church Leader',
                'slug' => 'leader',
                'description' => 'Church Leadership Team - Limited administrative access',
                'permissions' => ['view_reports', 'manage_events', 'view_parishioners'],
            ],
            [
                'name' => 'Secretary',
                'slug' => 'secretary',
                'description' => 'Church Secretary - Data entry and management access',
                'permissions' => ['create_parishioners', 'create_events', 'create_sms'],
            ],
            [
                'name' => 'Treasurer',
                'slug' => 'treasurer',
                'description' => 'Church Treasurer - Finance management access',
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
