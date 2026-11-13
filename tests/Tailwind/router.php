<?php
if (PHP_SAPI !== 'cli-server' || getenv('PR234_BROWSER_TEST') !== '1'
    || ! in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1'], true)) {
    http_response_code(404); exit;
}
$public = realpath(dirname(__DIR__, 2).'/public');
$path = realpath($public.'/'.rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
if ($path && str_starts_with($path, $public.'/') && is_file($path) && ! str_ends_with($path, '.php') && ! str_starts_with(basename($path), '.')) {
    return false;
}
$app = require __DIR__.'/bootstrap.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();
// Harness-only session provisioning; production authentication/OTP middleware stays enabled.
Illuminate\Support\Facades\Route::middleware('web')->get('/__pr234/session', function () {
    Illuminate\Support\Facades\Auth::loginUsingId(1);
    session()->regenerate();
    session(['admin_role' => 'school']);
    App\Support\OtpSession::markSent(123456);
    return redirect('/email-verification');
});
// Render probes for templates that have no production route. Do not invent their missing named routes.
foreach (['faq', 'auth.passwords.email', 'admin.settings', 'admin.subscribe', 'admin.checkout'] as $view) {
    Illuminate\Support\Facades\Route::middleware('web')->get('/__pr234/view/'.$view,
        fn () => view($view, ['subscription' => null, 'plan' => 'monthly', 'amount' => 0]));
}
$response = $kernel->handle($request = Illuminate\Http\Request::capture());
$response->send();
$kernel->terminate($request, $response);
