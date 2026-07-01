<?php

namespace App\Support;

class OtpSession
{
    public const TTL_MINUTES = 10;

    public const RESEND_COOLDOWN_SECONDS = 60;

    public static function clear(): void
    {
        session()->forget([
            'login_otp',
            'login_otp_sent_at',
            'login_otp_last_request',
            'otp_verified',
            'admin_role',
        ]);
    }

    public static function clearPending(): void
    {
        session()->forget([
            'login_otp',
            'login_otp_sent_at',
            'login_otp_last_request',
            'otp_verified',
        ]);
    }

    public static function markSent(int $otp): void
    {
        session([
            'login_otp' => $otp,
            'login_otp_sent_at' => now()->timestamp,
            'login_otp_last_request' => now()->timestamp,
        ]);
        session()->forget('otp_verified');
    }

    public static function isExpired(): bool
    {
        $sentAt = session('login_otp_sent_at');

        if (! $sentAt) {
            return true;
        }

        return now()->timestamp - $sentAt > (self::TTL_MINUTES * 60);
    }

    public static function isVerified(): bool
    {
        return session('otp_verified') === true;
    }

    public static function hasPendingOtp(): bool
    {
        return session()->has('login_otp') && ! self::isExpired();
    }

    public static function canResend(): bool
    {
        $lastRequest = session('login_otp_last_request');

        if (! $lastRequest) {
            return true;
        }

        return now()->timestamp - $lastRequest >= self::RESEND_COOLDOWN_SECONDS;
    }

    public static function resendCooldownRemaining(): int
    {
        $lastRequest = session('login_otp_last_request');

        if (! $lastRequest) {
            return 0;
        }

        $remaining = self::RESEND_COOLDOWN_SECONDS - (now()->timestamp - $lastRequest);

        return max(0, $remaining);
    }

    public static function verify(string $otp): bool
    {
        if (self::isExpired()) {
            return false;
        }

        return hash_equals((string) session('login_otp'), (string) $otp);
    }

    public static function markVerified(): void
    {
        session(['otp_verified' => true]);
        session()->forget(['login_otp', 'login_otp_sent_at', 'login_otp_last_request']);
    }
}
