<?php

namespace App\Services\Reports;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class TurnstileVerifier
{
    public function verify(mixed $token): void
    {
        $config = config('report_protection');
        if (! is_string($token) || $token === '' || strlen($token) > 2048) {
            $this->reject();
        }
        if (empty($config['secret_key']) || empty($config['site_key']) || empty($config['hostnames'])
            || $config['connect_timeout'] <= 0 || $config['timeout'] <= 0) {
            $this->reject('Verification is temporarily unavailable. Your report has not been submitted. Please try again later.');
        }

        try {
            // One idempotency key per verification, reused only for transport retries.
            $response = Http::asForm()
                ->connectTimeout($config['connect_timeout'])
                ->timeout($config['timeout'])
                ->retry(2, 200, when: fn ($exception) => $exception instanceof \Illuminate\Http\Client\ConnectionException
                    || ($exception instanceof \Illuminate\Http\Client\RequestException && $exception->response->serverError()),
                    throw: false)
                ->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                    'secret' => $config['secret_key'],
                    'response' => $token,
                    'idempotency_key' => (string) Str::uuid(),
                ]);
            $result = $response->json();
        } catch (\Throwable) {
            $this->reject('Verification could not connect. Your report has not been submitted. Please try again.');
        }

        if (! $response->successful() || ! is_array($result)
            || ($result['success'] ?? null) !== true
            || ! in_array($result['hostname'] ?? null, $config['hostnames'], true)
            || ($result['action'] ?? null) !== $config['action']) {
            $this->reject();
        }
    }

    private function reject(string $message = 'Please complete a fresh verification and try again.'): never
    {
        throw ValidationException::withMessages(['turnstileToken' => $message]);
    }
}
