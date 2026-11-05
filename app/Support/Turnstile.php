<?php

namespace App\Support;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Turnstile
{
    private const VERIFY_URL = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';

    /** Active only when BOTH keys are set, so a half-finished setup can never lock everyone out. */
    public static function enabled(): bool
    {
        return filled(config('services.turnstile.site_key')) && filled(config('turnstile.secret_key'));
    }

    public static function verify(?string $token, ?string $ip = null): bool
    {
        if (! self::enabled()) {
            return true;
        }
        if (blank($token)) {
            return false;
        }

        try {
            $response = Http::asForm()->timeout(5)->post(self::VERIFY_URL, [
                'secret'   => config('turnstile.secret_key'),
                'response' => $token,
                'remoteip' => $ip,
            ]);
        } catch (\Throwable $e) {
            Log::warning('Turnstile unreachable, allowing request: ' . $e->getMessage());
            return true;
        }

        if ($response->serverError()) {
            Log::warning('Turnstile returned ' . $response->status() . ', allowing request');
            return true;
        }

        return (bool) $response->json('success');
    }
}
