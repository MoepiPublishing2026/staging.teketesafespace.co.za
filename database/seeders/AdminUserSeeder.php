<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    // Set each account's *_PASSWORD value in the deployment environment before seeding.
    // The corresponding *_NAME and *_EMAIL values are required as well.
    /**
     * Create configured admin accounts without changing existing credentials.
     */
    public function run(): void
    {
        foreach (config('seed_admins.accounts', []) as $account) {
            if (empty($account['name']) || empty($account['email']) || empty($account['password'])) {
                continue;
            }

            User::firstOrCreate(
                ['username' => $account['username']],
                [
                    'name' => $account['name'],
                    'email' => $account['email'],
                    'password' => Hash::make($account['password']),
                    'role' => 'admin',
                ]
            );
        }
    }
}
