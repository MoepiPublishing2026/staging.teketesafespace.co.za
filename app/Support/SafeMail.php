<?php

namespace App\Support;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SafeMail
{
    private const SOCKET_TIMEOUT_SECONDS = 10;

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
