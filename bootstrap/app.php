<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo('/school-admin');

        // Exclude PayFast ITN callback from CSRF verification
        $middleware->validateCsrfTokens(except: [
            'payment/notify',
        ]);

        // Register the subscription middleware alias
        $middleware->alias([
            'subscribed' => \App\Http\Middleware\EnsureSchoolSubscribed::class,
            'otp.verified' => \App\Http\Middleware\EnsureOtpVerified::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
