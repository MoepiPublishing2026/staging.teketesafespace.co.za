<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class TurnstileVerifier
{
    public function verify(mixed $token): void
    {
        if (! is_string($token) || $token === '' || strlen($token) > 2048) {
            $this->reject();
        }
        $config = config('turnstile');
        if (empty($config['secret_key']) || empty($config['site_key']) || empty($config['hostnames'])) {
            $this->reject('Verification is temporarily unavailable. Your entries are preserved. Please try again later.');
        }
        try {
            $response = Http::asForm()->connectTimeout($config['connect_timeout'])->timeout($config['timeout'])
                ->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                    'secret' => $config['secret_key'], 'response' => $token,
                ]);
            $result = $response->json();
        } catch (\Throwable) {
            $this->reject('Verification could not connect. Your entries are preserved. Please try again.');
        }
        if (! $response->successful() || ! is_array($result) || ($result['success'] ?? null) !== true
            || ! in_array($result['hostname'] ?? null, $config['hostnames'], true)
            || ($result['action'] ?? null) !== 'report_submit') {
            $this->reject();
        }
    }

    private function reject(string $message = 'Please complete a fresh verification and try again.'): never
    {
        throw ValidationException::withMessages(['turnstileToken' => $message]);
    }
}
