<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminLoginForm extends Component
{
    public $username = '';
    public $password = '';
    public $role = ''; // added for selected role
    public $showOtpForm = false;

    // Defined rules for Livewire validation
    // These will be used when the wire:model.live directives update
    protected $rules = [
        'role' => 'required',
        'username' => 'required',
        'password' => [
            'required',
            'string',
            'min:8', 
            'max:50',
            'regex:/[A-Z]/',                 // Must contain at least one uppercase letter
            'regex:/[0-9]/',                 // Must contain at least one digit
            'regex:/[\W_]/',                 // Must contain at least one special character
        ],
    ];

    // Custom messages for validation
    public function messages()
    {
        return [
            'role.required' => 'Please select your role before logging in.',
            'password.min' => 'The password must be a minimum of 8 characters.',
             'password.max' => 'The password may not be greater than 50 characters.', // <--- ADDED: Custom message
            'password.regex' => 'The password must contain at least one uppercase letter, one number, and one special character.',
        ];
    }

    public function login()
    {
        // Validate the input fields, using the custom messages defined above.
        $this->validate();

        // Find user by username
        $user = User::where('username', $this->username)->first();

        if (!$user) {
            $this->addError('login', 'User not found.');
            return;
        }

        // Check if role matches
        if ($user->role !== $this->role) {
            $this->addError('login', 'Incorrect administrator role selected.');
            return;
        }

        // Attempt login
        if (Auth::attempt(['username' => $this->username, 'password' => $this->password])) {
            session(['admin_role' => $this->role]); // store role for next page
            return redirect()->route('email.verification');
        }

        $this->addError('login', 'The provided credentials do not match our records.');
    }

    public function render()
    {
        return view('livewire.admin-login-form');
    }
    
    public function resetForm()
    {
        // Reset the input fields when role changes
        $this->reset(['username', 'password', 'showOtpForm']);
        
        // Optionally clear validation errors
        $this->resetErrorBag();
    }
}