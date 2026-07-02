<?php

namespace App\Support;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class SafeNotify
{
    private const SOCKET_TIMEOUT_SECONDS = 10;

    public static function sendAfterResponse(mixed $notifiable, Notification $notification): void
    {
        dispatch(static function () use ($notifiable, $notification): void {
            self::send($notifiable, $notification);
        })->afterResponse();
    }

    public static function send(mixed $notifiable, Notification $notification): bool
    {
        $previousSocketTimeout = ini_get('default_socket_timeout');
        ini_set('default_socket_timeout', (string) self::SOCKET_TIMEOUT_SECONDS);

        try {
            $notifiable->notify($notification);

            return true;
        } catch (\Throwable $e) {
            Log::error('Notification delivery failed.', [
                'notifiable' => is_object($notifiable) ? $notifiable::class : gettype($notifiable),
                'notification' => $notification::class,
                'error' => $e->getMessage(),
            ]);

            return false;
        } finally {
            ini_set('default_socket_timeout', $previousSocketTimeout);
        }
    }
}
