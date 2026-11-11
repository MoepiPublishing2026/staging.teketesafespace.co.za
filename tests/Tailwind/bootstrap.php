<?php

// Deliberately separate from the app's environment, storage and database.
$root = dirname(__DIR__, 2);
$runtime = getenv('PR234_RUNTIME');
if (getenv('PR234_BROWSER_TEST') !== '1' || ! $runtime || ! str_starts_with($runtime, '/')) {
    throw new RuntimeException('Explicit isolated browser-test runtime required.');
}
foreach (['environment', 'bootstrap', 'storage/framework/views', 'storage/framework/cache/data', 'storage/framework/sessions', 'storage/logs'] as $path) {
    if (! is_dir($runtime.'/'.$path)) mkdir($runtime.'/'.$path, 0777, true);
}
foreach ([
    'APP_ENV' => 'testing', 'APP_DEBUG' => 'true',
    'APP_KEY' => 'base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=',
    'APP_URL' => getenv('PR234_ORIGIN') ?: 'http://127.0.0.1:8794',
    'APP_CONFIG_CACHE' => $runtime.'/bootstrap/config.php',
    'APP_SERVICES_CACHE' => $runtime.'/bootstrap/services.php',
    'APP_PACKAGES_CACHE' => $runtime.'/bootstrap/packages.php',
    'DB_CONNECTION' => 'sqlite', 'DB_DATABASE' => $runtime.'/database.sqlite', 'DB_URL' => '',
    'SESSION_DRIVER' => 'file', 'SESSION_COOKIE' => 'pr234_isolated_session',
    'SESSION_SECURE_COOKIE' => 'false', 'CACHE_STORE' => 'file',
    'MAIL_MAILER' => 'array', 'QUEUE_CONNECTION' => 'sync', 'LOG_CHANNEL' => 'single',
    'TURNSTILE_SITE_KEY' => '', 'TURNSTILE_SECRET' => '',
] as $key => $value) {
    putenv($key.'='.$value);
    $_ENV[$key] = $_SERVER[$key] = $value;
}
require $root.'/vendor/autoload.php';
$app = require $root.'/bootstrap/app.php';
$app->useEnvironmentPath($runtime.'/environment');
$app->useStoragePath($runtime.'/storage');
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
if (config('database.default') !== 'sqlite' || config('database.connections.sqlite.database') !== $runtime.'/database.sqlite') {
    throw new RuntimeException('Isolated database configuration failed.');
}
return $app;
