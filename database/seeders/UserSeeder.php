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
        $padriRole = Role::where('slug', 'padri')->first();
        $viongoziRole = Role::where('slug', 'viongozi')->first();
        $katibuRole = Role::where('slug', 'katibu')->first();
        $mwekaHazinaRole = Role::where('slug', 'mweka_hazina')->first();
        $adminRole = Role::where('slug', 'system_admin')->first();

        // Create Padri (Full Access)
        User::create([
            'name' => 'Padri John',
            'email' => 'padri@example.com',
            'password' => Hash::make('password'),
            'role_id' => $padriRole->id ?? 1,
        ]);

        // Create Viongozi
        User::create([
            'name' => 'Kiongozi Mkuu',
            'email' => 'viongozi@example.com',
            'password' => Hash::make('password'),
            'role_id' => $viongoziRole->id ?? 2,
        ]);

        // Create Katibu
        User::create([
            'name' => 'Katibu',
            'email' => 'katibu@example.com',
            'password' => Hash::make('password'),
            'role_id' => $katibuRole->id ?? 3,
        ]);

        // Create Mweka Hazina
        User::create([
            'name' => 'Mweka Hazina',
            'email' => 'hazina@example.com',
            'password' => Hash::make('password'),
            'role_id' => $mwekaHazinaRole->id ?? 4,
        ]);

        // Create System Admin
        User::create([
            'name' => 'System Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id ?? 5,
        ]);
    }
}
