<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Disable foreign key checks to allow truncating tables
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        $this->call([
            AbuseTypesSeeder::class,
            SubtypesSeeder::class,
            AdminUserSeeder::class,
            SchoolSeeder::class,
            // Add other seeders here
        ]);

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
