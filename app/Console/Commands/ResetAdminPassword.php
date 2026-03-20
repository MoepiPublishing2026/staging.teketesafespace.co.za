<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ResetAdminPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:reset-password {username?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resets the password for a specific administrator by username.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // 1. Get the target username
        $username = $this->argument('username');
        if (!$username) {
            $username = $this->ask('Enter the username of the administrator whose password you want to reset');
        }

        // 2. Find the user
        // Ensure you are using the correct model (assuming it's App\Models\User)
        $user = User::where('username', $username)->first();

        if (!$user) {
            $this->error("Administrator with username '{$username}' not found.");
            return 1;
        }

        $this->info("Found administrator: {$user->username} ({$user->role} role).");

        // 3. Prompt for the new password
        $newPassword = $this->secret('Enter the new secure password');
        $confirmPassword = $this->secret('Confirm the new secure password');

        if ($newPassword !== $confirmPassword) {
            $this->error('The passwords do not match. Operation cancelled.');
            return 1;
        }

        // 4. Validate the new password against the security policy
        // This validation mirrors the strict rules in your AdminLoginForm component
        $validator = Validator::make(['password' => $newPassword], [
            'password' => [
                'required',
                'string',
                'min:8',
                'max:50',
                'regex:/[A-Z]/',    // Must contain at least one uppercase letter
                'regex:/[0-9]/',    // Must contain at least one digit
                'regex:/[\W_]/',    // Must contain at least one special character
            ],
        ]);

        if ($validator->fails()) {
            $this->error('The new password does not meet the security requirements:');
            foreach ($validator->errors()->all() as $error) {
                $this->warn("- {$error}");
            }
            return 1;
        }

        // 5. Update the user record with the HASHED password
        // CRITICAL STEP: Always use Hash::make() before saving to the database
        $user->password = Hash::make($newPassword);
        $user->save();

        $this->comment("\nSuccessfully reset password for: {$user->username}");
        $this->comment('The administrator can now log in with the new password.');
        
        return 0;
    }
}