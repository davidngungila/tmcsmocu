<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get roles
        $priestRole = Role::where('slug', 'priest')->first();
        $leaderRole = Role::where('slug', 'leader')->first();
        $secretaryRole = Role::where('slug', 'secretary')->first();
        $treasurerRole = Role::where('slug', 'treasurer')->first();
        $adminRole = Role::where('slug', 'system_admin')->first();

        // Create Priest (Full Access)
        User::create([
            'name' => 'Father John Smith',
            'email' => 'priest@church.com',
            'password' => Hash::make('password123'),
            'role_id' => $priestRole->id ?? 1,
        ]);

        // Create Church Leader
        User::create([
            'name' => 'Michael Johnson',
            'email' => 'leader@church.com',
            'password' => Hash::make('password123'),
            'role_id' => $leaderRole->id ?? 2,
        ]);

        // Create Secretary
        User::create([
            'name' => 'Sarah Williams',
            'email' => 'secretary@church.com',
            'password' => Hash::make('password123'),
            'role_id' => $secretaryRole->id ?? 3,
        ]);

        // Create Treasurer
        User::create([
            'name' => 'David Brown',
            'email' => 'treasurer@church.com',
            'password' => Hash::make('password123'),
            'role_id' => $treasurerRole->id ?? 4,
        ]);

        // Create System Admin
        User::create([
            'name' => 'System Administrator',
            'email' => 'admin@church.com',
            'password' => Hash::make('admin123'),
            'role_id' => $adminRole->id ?? 5,
        ]);
    }
}
