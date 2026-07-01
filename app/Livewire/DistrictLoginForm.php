<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Support\OtpSession;

class DistrictLoginForm extends Component
{
    public $username = '';
    public $password = '';
    public $role = '';

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
            OtpSession::clearPending();
            session(['admin_role' => $this->role]);
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
        $this->reset(['username', 'password']);
        
        // Optionally clear validation errors
        $this->resetErrorBag();
    }

}
