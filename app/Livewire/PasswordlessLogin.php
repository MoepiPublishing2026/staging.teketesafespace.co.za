<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Mail\LoginOtpMail;
use App\Support\OtpSession;
use App\Support\SafeMail;

class PasswordlessLogin extends Component
{
    public $email;

    public $otp;

    public $showOtpForm = false;

    public $role;

    public function mount()
    {
        $this->role = session('admin_role');

        if (Auth::check()) {
            $this->email = Auth::user()->email;
        }

        if (OtpSession::isVerified()) {
            return $this->handleFinalRedirect();
        }

        $this->showOtpForm = OtpSession::hasPendingOtp();
    }

    public function sendOtp()
    {
        $this->validate(['email' => 'required|email|exists:users,email']);

        $user = Auth::user();

        if (! $user || $user->email !== $this->email) {
            $this->addError('email', 'The provided email does not match the logged-in user.');
            return;
        }

        if (! OtpSession::canResend()) {
            $seconds = OtpSession::resendCooldownRemaining();
            $this->addError('email', "Please wait {$seconds} seconds before requesting another OTP.");
            return;
        }

        $otp = random_int(100000, 999999);
        OtpSession::markSent($otp);

        if (! SafeMail::send($user->email, new LoginOtpMail($otp))) {
            OtpSession::clearPending();
            Log::error('Failed to send OTP', ['email' => $user->email]);
            $this->addError('email', 'Unable to send OTP. Please verify your email settings and try again.');
            return;
        }

        $this->showOtpForm = true;
    }

    public function login()
    {
        $this->validate(['otp' => 'required|digits:6']);

        if (OtpSession::isExpired()) {
            OtpSession::clearPending();
            $this->showOtpForm = false;
            $this->addError('otp', 'This OTP has expired. Please request a new one.');
            return;
        }

        if (OtpSession::verify($this->otp)) {
            OtpSession::markVerified();

            return $this->handleFinalRedirect();
        }

        $this->addError('otp', 'The provided OTP is incorrect.');
    }

    private function handleFinalRedirect()
    {
        $role = session('admin_role');

        return match ($role) {
            'school' => redirect()->route('admin.dashboard'),
            'district' => redirect()->route('district.admin.dashboard'),
            'provincial' => redirect()->route('provincial.admin.dashboard'),
            'national' => redirect()->route('national.admin.dashboard'),
            default => redirect()->route('admin.dashboard'),
        };
    }

    public function render()
    {
        return view('livewire.passwordless-login');
    }
}
