<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed permissions and roles using the comprehensive seeder
        $this->call([
            ComprehensivePermissionsSeeder::class,
        ]);
    }
}
