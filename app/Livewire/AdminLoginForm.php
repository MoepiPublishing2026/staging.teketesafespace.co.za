<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use App\Support\OtpSession;
use App\Services\TurnstileVerifier;
use Illuminate\Validation\ValidationException;

class AdminLoginForm extends Component
{
    private const LOGIN_LOCKOUT_MINUTES = 5;

    public $username = '';
    public $password = '';
    public string $turnstileToken = '';
    public string $website = '';
    public string $captchaError = '';
    public bool $showCaptcha = false;

    public function mount(): void
    {
        session(['admin_login_form_started_at' => now()->timestamp]);
    }

    private function limiterKey(): string
    {
        return 'admin-login:'.sha1(strtolower(trim($this->username)).'|'.request()->ip());
    }

    private function failureCountKey(): string
    {
        return $this->limiterKey().':failures';
    }

    private function lockKey(): string
    {
        return $this->limiterKey().':lock';
    }

    private function ipFailureCountKey(): string
    {
        return 'admin-login-ip:'.sha1((string) request()->ip()).':failures';
    }

    private function ipLockKey(): string
    {
        return 'admin-login-ip:'.sha1((string) request()->ip()).':lock';
    }

    public function verifyTurnstile(string $turnstileToken)
    {
        $this->turnstileToken = $turnstileToken;
        $this->captchaError = '';
        if (!$this->showCaptcha) {
            $this->captchaError = 'Security verification is unavailable. Please contact the site administrator.';
            $this->dispatch('admin-turnstile-reset');
            return;
        }

        try {
            app(TurnstileVerifier::class)->verify($this->turnstileToken, 'admin_login');
        } catch (ValidationException $exception) {
            $this->captchaError = $exception->errors()['turnstileToken'][0] ?? 'Security verification could not be confirmed. Please try again.';
            $this->dispatch('admin-turnstile-reset');
            return;
        }

        session(['admin_login_turnstile_passed' => [
            'key' => $this->limiterKey(),
            'expires_at' => now()->addMinutes(2)->timestamp,
        ]]);
        $this->captchaError = '';

        // Continue in this verified Livewire request instead of relying on a
        // browser event to issue a second login request.
        return $this->login();
    }

    private function activeLockUntil()
    {
        $locks = [Cache::get($this->lockKey()), Cache::get($this->ipLockKey())];
        $locks = array_filter($locks, fn ($lock) => $lock && now()->lt($lock));

        return collect($locks)->sortByDesc(fn ($lock) => $lock->getTimestamp())->first();
    }

    public function getCaptchaPassedProperty(): bool
    {
        $proof = session('admin_login_turnstile_passed');

        return is_array($proof)
            && ($proof['key'] ?? null) === $this->limiterKey()
            && (int) ($proof['expires_at'] ?? 0) >= now()->timestamp;
    }

    private function recordFailedPassword(): void
    {
        $attempts = (int) Cache::get($this->failureCountKey(), 0) + 1;
        $ipAttempts = (int) Cache::get($this->ipFailureCountKey(), 0) + 1;
        Cache::put($this->failureCountKey(), $attempts, now()->addMinutes(self::LOGIN_LOCKOUT_MINUTES));
        Cache::put($this->ipFailureCountKey(), $ipAttempts, now()->addMinutes(self::LOGIN_LOCKOUT_MINUTES));

        if ($attempts >= 3) {
            Cache::put($this->lockKey(), now()->addMinutes(self::LOGIN_LOCKOUT_MINUTES), now()->addMinutes(self::LOGIN_LOCKOUT_MINUTES));
            $this->addError('login', 'The password is incorrect. Too many failed attempts; login is now locked. Wait for the countdown before trying again. Use Forgot password or contact your administrator if you need help.');
        } elseif ($ipAttempts >= 10) {
            Cache::put($this->ipLockKey(), now()->addMinutes(self::LOGIN_LOCKOUT_MINUTES), now()->addMinutes(self::LOGIN_LOCKOUT_MINUTES));
            $this->addError('login', 'Too many failed login attempts from this network. Login is locked for 5 minutes.');
        } else {
            if ($attempts >= 2) {
                $delay = 2 ** $attempts;
                Cache::put($this->lockKey(), now()->addSeconds($delay), now()->addSeconds($delay));
            }
            $this->addError('login', 'The provided credentials do not match our records.');
        }
    }

    public function getIsLockedProperty(): bool
    {
        return (bool) $this->activeLockUntil();
    }

    public function getLockoutUntilProperty(): ?int
    {
        $lockedUntil = $this->activeLockUntil();

        return $lockedUntil ? $lockedUntil->getTimestamp() * 1000 : null;
    }

    // Defined rules for Livewire validation
    // These will be used when the wire:model.live directives update
    protected $rules = [
        'username' => 'required',
        'password' => ['required', 'string'],
    ];

    public function login()
    {
        // Validate the input fields, using the custom messages defined above.
        $this->validate();

        if ($this->website !== '') {
            $this->addError('login', 'Unable to verify this request. Refresh the page and try again.');
            return;
        }

        if (now()->timestamp - (int) session('admin_login_form_started_at', now()->timestamp) < 2) {
            $this->addError('login', 'Please wait a moment, then try again.');
            return;
        }

        $attempts = (int) Cache::get($this->failureCountKey(), 0);
        $lockedUntil = $this->activeLockUntil();
        if ($lockedUntil) {
            $this->addError('login', 'Too many incorrect passwords. Login is locked. Wait for the countdown before trying again. Use Forgot password or contact your administrator if you need help.');
            return;
        }
        if ($attempts >= 3) {
            Cache::forget($this->failureCountKey());
            $attempts = 0;
        }

        if (!$this->captchaPassed) {
            $this->showCaptcha = true;
            $this->captchaError = '';
            $this->dispatch('admin-turnstile-open');
            return;
        }

        // Attempt login. A database outage must return the user to a retryable
        // state instead of leaving the CAPTCHA modal on its success screen.
        try {
            $authenticated = Auth::attempt(['username' => $this->username, 'password' => $this->password]);
        } catch (QueryException $exception) {
            Log::error('Admin login unavailable because the user database could not be reached.', [
                'exception' => get_class($exception),
            ]);
            session()->forget('admin_login_turnstile_passed');
            $this->showCaptcha = false;
            $this->addError('login', 'Sign-in is temporarily unavailable. Please try again shortly.');
            return;
        }

        if ($authenticated) {
            $role = (string) Auth::user()->role;
            if (!in_array($role, ['school', 'district', 'provincial', 'national', 'admin'], true)) {
                Auth::logout();
                session()->forget('admin_login_turnstile_passed');
                $this->showCaptcha = false;
                $this->addError('login', 'The provided credentials do not match our records.');
                return;
            }

            Cache::forget($this->failureCountKey());
            Cache::forget($this->lockKey());
            session()->forget('admin_login_turnstile_passed');
            $this->showCaptcha = false;
            OtpSession::clearPending();
            session(['admin_role' => $role]);
            return redirect()->route('email.verification');
        }

        session()->forget('admin_login_turnstile_passed');
        $this->showCaptcha = false;
        $this->recordFailedPassword();
    }

    public function render()
    {
        return view('livewire.admin-login-form')
            ->layout('components.layouts.app', ['title' => 'Admin Login | Tekete SafeSpace']);
    }
    
    public function resetForm()
    {
        // Clear the input and CAPTCHA state for a fresh attempt.
        $this->reset(['username', 'password', 'turnstileToken', 'website', 'captchaError', 'showCaptcha']);
        session()->forget('admin_login_turnstile_passed');
        
        // Optionally clear validation errors
        $this->resetErrorBag();
    }
}
