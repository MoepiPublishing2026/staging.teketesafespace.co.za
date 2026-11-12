<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Keep the legacy seeder entry point safe by using the configured admin seeder.
     */
    public function run(): void
    {
        $this->call(AdminUserSeeder::class);
    }
}
