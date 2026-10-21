<?php

// Local browser harness only. Fixed disposable SQLite fixture; never .env's DB.
if (PHP_SAPI !== 'cli-server' || getenv('REPORT_BROWSER_ENABLE') !== '1'
    || ($_SERVER['REMOTE_ADDR'] ?? '') !== '127.0.0.1') {
    http_response_code(403);
    exit;
}
putenv('APP_ENV=testing');
putenv('DB_CONNECTION=sqlite');
putenv('DB_DATABASE='.__DIR__.'/.runtime/browser.sqlite');
putenv('APP_KEY=base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=');
putenv('SESSION_DRIVER=file');
putenv('LOG_CHANNEL=null');
require __DIR__.'/bootstrap.php';
$app = createReportTestApplication();
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();
config(['report_protection.site_key' => '1x00000000000000000000AA',
    'report_protection.secret_key' => 'browser-test-only',
    'report_protection.hostnames' => ['127.0.0.1'],
]);
Illuminate\Support\Facades\Http::fake(['challenges.cloudflare.com/*' => Illuminate\Support\Facades\Http::response([
    'success' => true, 'hostname' => '127.0.0.1', 'action' => 'report_submit',
])]);
Illuminate\Support\Facades\Mail::fake();
$request = Illuminate\Http\Request::capture();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
