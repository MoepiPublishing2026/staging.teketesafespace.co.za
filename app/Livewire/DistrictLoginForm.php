<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DistrictLoginForm extends Component
{
    public $username = '';
    public $password = '';
    public $role = ''; // added for selected role
    public $showOtpForm = false;

    protected $rules = [
        'role' => 'required',
        'username' => 'required',
        'password' => 'required',
    ];

    public function login()
    {
        $this->validate([
        'role' => 'required',
        'username' => 'required',
        'password' => 'required',
    ], [
        'role.required' => 'Please select your role before logging in.',
    ]);


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
