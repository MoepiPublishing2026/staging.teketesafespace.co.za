<?php

use App\Http\Middleware\HandleAdminGracefully;
use App\Support\AdminGuard;
use App\Support\AdminRoutes;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo('/school-admin');

        $middleware->web(append: [
            HandleAdminGracefully::class,
        ]);

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
        $exceptions->render(function (\Throwable $e, Request $request) {
            if (! AdminRoutes::matches($request)) {
                return null;
            }

            AdminGuard::log($e);

            $message = AdminGuard::userMessage();

            if ($request->is('livewire/*') || $request->header('X-Livewire')) {
                return response()->view('errors.admin-minimal', [
                    'message' => $message,
                ], 200);
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $message,
                ], 422);
            }

            if ($request->isMethod('GET')) {
                return response()->view('errors.admin', [
                    'message' => $message,
                    'backUrl' => AdminRoutes::fallbackUrl($request),
                ], 500);
            }

            return redirect()
                ->to(url()->previous() ?: AdminRoutes::fallbackUrl($request))
                ->withInput($request->except('password', '_token', 'otp'))
                ->with('error_message', $message);
        });
    })->create();
