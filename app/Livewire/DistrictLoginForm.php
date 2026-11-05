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

    protected $rules = [
        'username' => 'required|string|max:100',
        'password' => 'required|string|max:255',
    ];

    public function login()
    {
        $this->validate([
            'username' => 'required|string|max:100',
            'password' => 'required|string|max:255',
        ]);


        // Find user by username
        $user = User::where('username', $this->username)->first();

        if (!$user || $user->role !== 'district') {
            $this->addError('login', 'The provided credentials do not match our records.');
            return;
        }

        // Attempt login
        if (Auth::attempt(['username' => $this->username, 'password' => $this->password])) {
            OtpSession::clearPending();
            session(['admin_role' => $user->role]);
            return redirect()->route('email.verification');
        }

        $this->addError('login', 'The provided credentials do not match our records.');
    }

    public function render()
    {
        return view('livewire.admin-login-form')
            ->layout('components.layouts.app', ['title' => 'District Admin Login | Tekete SafeSpace']);
    }
    
    public function resetForm()
    {
        // Clear the input fields for a fresh attempt.
        $this->reset(['username', 'password']);
        
        // Optionally clear validation errors
        $this->resetErrorBag();
    }

}
