<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\LoginOtpMail;
use App\Models\User;

class PasswordlessLogin extends Component
{
    public $email;
    public $otp;
    public $showOtpForm = false;
    public $role;

    public function mount()
    {
        // Get role from session (set in AdminLoginForm)
        $this->role = session('admin_role');

        // Pre-fill email with logged-in user's email if available
        if (Auth::check()) {
            $this->email = Auth::user()->email;
        }

        $this->showOtpForm = false;
    }

    public function sendOtp()
    {
        $this->validate(['email' => 'required|email|exists:users,email']);

        $user = Auth::user();

        // Verify the email belongs to the logged-in admin
        if (!$user || $user->email !== $this->email) {
            $this->addError('email', 'The provided email does not match the logged-in user.');
            return;
        }

        // Generate OTP
        $otp = random_int(100000, 999999);
        session(['login_otp' => $otp]);

        try {
            Mail::to($user->email)->send(new LoginOtpMail($otp));
        } catch (\Throwable $e) {
            \Log::error('Failed to send OTP', [
                'email' => $user->email,
                'error' => $e->getMessage(),
            ]);

            $this->addError('email', 'Unable to send OTP. Please verify your email settings and try again.');
            return;
        }

        $this->showOtpForm = true;
    }

    public function login()
    {
        $this->validate(['otp' => 'required']);

        if ($this->otp == session('login_otp')) {

            session(['otp_verified' => true]);

            // Always redirect after OTP verification
            return $this->handleFinalRedirect();

        } else {
            $this->addError('otp', 'The provided OTP is incorrect.');
        }
    }

    public function redirectToSubscribe()
    {
        session()->put('has_full_access', true);
        return redirect()->route('admin.subscribe');
    }

    public function skipSubscription()
    {
        session(['has_full_access' => false]);
        session()->save();

        return $this->handleFinalRedirect();
    }

    private function handleFinalRedirect()
    {
        $role = session('admin_role');

        switch ($role) {
            case 'school':
                return redirect()->route('admin.dashboard');

            case 'district':
                return redirect()->route('district.admin.dashboard');

            case 'provincial':
                return redirect()->route('provincial.admin.dashboard');

            case 'national':
                return redirect()->route('national.admin.dashboard');

            default:
                return redirect()->route('admin.dashboard');
        }
    }

    public function render()
    {
        return view('livewire.passwordless-login');
    }
}