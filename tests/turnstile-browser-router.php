<?php

// Only for the loopback browser harness. Never load the application's .env.
if (PHP_SAPI !== 'cli-server' || getenv('REPORT_WIDGET_BROWSER_TEST') !== '1'
    || ! in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1'], true)) {
    http_response_code(404);
    exit;
}
// No submissions, uploads or mail, even if the browser test is changed by mistake.
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    exit;
}
if (parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === '/js/report-turnstile.js') {
    header('Content-Type: application/javascript');
    readfile(dirname(__DIR__).'/public/js/report-turnstile.js');
    exit;
}
foreach (['APP_ENV' => 'testing', 'APP_KEY' => 'base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=',
    'DB_CONNECTION' => 'sqlite', 'DB_DATABASE' => ':memory:', 'DB_URL' => '',
    'SESSION_DRIVER' => 'array', 'CACHE_STORE' => 'array', 'MAIL_MAILER' => 'array',
    'QUEUE_CONNECTION' => 'sync', 'LOG_CHANNEL' => 'null'] as $key => $value) {
    putenv($key.'='.$value);
    $_ENV[$key] = $_SERVER[$key] = $value;
}
require __DIR__.'/bootstrap.php';
$app = createTurnstileTestApplication();
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();
if (config('database.default') !== 'sqlite' || config('database.connections.sqlite.database') !== ':memory:') {
    throw new RuntimeException('Browser fixture requires in-memory SQLite.');
}
config(['turnstile.site_key' => getenv('REPORT_WIDGET_BROWSER_SITE_KEY')]);
(require __DIR__.'/report-fixture.php')();
$response = $kernel->handle($request = Illuminate\Http\Request::capture());
$response->send();
$kernel->terminate($request, $response);
