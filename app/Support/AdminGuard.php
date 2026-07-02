<?php

namespace App\Support;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class AdminGuard
{
    public const USER_MESSAGE = 'Something went wrong. Please try again. If this keeps happening, contact support.';

    public static function userMessage(): string
    {
        return self::USER_MESSAGE;
    }

    public static function log(Throwable $e): void
    {
        Log::error('Admin action failed', [
            'exception' => $e::class,
            'message' => $e->getMessage(),
            'url' => request()->fullUrl(),
        ]);
    }

    public static function run(callable $action, ?callable $onFailure = null): mixed
    {
        try {
            return $action();
        } catch (ValidationException $e) {
            throw $e;
        } catch (Throwable $e) {
            self::log($e);

            if ($onFailure) {
                return $onFailure($e);
            }

            return null;
        }
    }
}
