<?php

namespace App\Support;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SafeMail
{
    private const SOCKET_TIMEOUT_SECONDS = 10;

    public static function sendReliable(string $to, Mailable $mailable): bool
    {
        $previousSocketTimeout = ini_get('default_socket_timeout');
        $timeout = (int) config('mail.mailers.smtp.timeout', 30);
        ini_set('default_socket_timeout', (string) max($timeout, self::SOCKET_TIMEOUT_SECONDS));

        $attempts = self::smtpAttempts();
        $lastError = null;

        try {
            foreach ($attempts as $attempt) {
                config([
                    'mail.mailers.smtp.scheme' => $attempt['scheme'],
                    'mail.mailers.smtp.port' => $attempt['port'],
                ]);
                Mail::purge('smtp');

                try {
                    Mail::mailer('smtp')->to($to)->send($mailable);

                    return true;
                } catch (\Throwable $e) {
                    $lastError = $e;
                    Log::warning('SMTP attempt failed.', [
                        'to' => $to,
                        'scheme' => $attempt['scheme'],
                        'port' => $attempt['port'],
                        'error' => $e->getMessage(),
                    ]);
                }
            }

            Log::error('Reliable mail delivery failed.', [
                'to' => $to,
                'error' => $lastError?->getMessage(),
            ]);

            return false;
        } finally {
            ini_set('default_socket_timeout', $previousSocketTimeout);
        }
    }

    /**
     * @return list<array{scheme: string, port: int}>
     */
    private static function smtpAttempts(): array
    {
        $configured = [
            'scheme' => (string) config('mail.mailers.smtp.scheme', 'smtp'),
            'port' => (int) config('mail.mailers.smtp.port', 587),
        ];

        $fallbacks = [
            ['scheme' => 'smtp', 'port' => 587],
            ['scheme' => 'smtps', 'port' => 465],
        ];

        $attempts = [$configured];

        foreach ($fallbacks as $fallback) {
            $duplicate = collect($attempts)->contains(
                fn (array $attempt) => $attempt['scheme'] === $fallback['scheme'] && $attempt['port'] === $fallback['port']
            );

            if (! $duplicate) {
                $attempts[] = $fallback;
            }
        }

        return $attempts;
    }

    public static function sendAfterResponse(string $to, Mailable $mailable): void
    {
        dispatch(static function () use ($to, $mailable): void {
            self::send($to, $mailable);
        })->afterResponse();
    }

    public static function send(string $to, Mailable $mailable): bool
    {
        $previousSocketTimeout = ini_get('default_socket_timeout');
        ini_set('default_socket_timeout', (string) self::SOCKET_TIMEOUT_SECONDS);

        try {
            $defaultMailer = config('mail.default');

            if (in_array($defaultMailer, ['failover', 'smtp'], true)) {
                try {
                    Mail::mailer('smtp')->to($to)->send($mailable);

                    return true;
                } catch (\Throwable $e) {
                    Log::warning('SMTP mail delivery failed, falling back to log mailer.', [
                        'to' => $to,
                        'error' => $e->getMessage(),
                    ]);
                }

                Mail::mailer('log')->to($to)->send($mailable);

                return true;
            }

            Mail::to($to)->send($mailable);

            return true;
        } catch (\Throwable $e) {
            Log::error('Mail delivery failed.', [
                'to' => $to,
                'error' => $e->getMessage(),
            ]);

            return false;
        } finally {
            ini_set('default_socket_timeout', $previousSocketTimeout);
        }
    }
}
