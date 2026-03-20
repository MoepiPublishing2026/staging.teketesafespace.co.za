<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or update the admin user
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'admin',
                'email' => 'janet.lehike@tekete.co.za',
                'password' => Hash::make('#admin25'), // Use a secure password
            ]
        );
        // Create or update the second admin user
        User::updateOrCreate(
            ['username' => 'secondadmin'],
            [
                'name' => 'secondadmin',
                'email' => 'nomkhuleko.tabete@tekete.co.za',
                'password' => Hash::make('#admin26'), // Use a secure password
            ]
        );
        // Create or update the second admin user
        User::updateOrCreate(
            ['username' => 'safespace'],
            [
                'name' => 'safespace',
                'email' => 'elvis.kgomo@tekete.co.za',
                'password' => Hash::make('safespace@2'), // Use a secure password
            ]
        );
    }
}