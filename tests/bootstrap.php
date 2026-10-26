<?php

$root = dirname(__DIR__);
$runtime = __DIR__.'/.runtime';
foreach (['environment', 'bootstrap', 'public/images', 'storage/framework/views', 'storage/framework/cache/data', 'storage/framework/sessions', 'storage/logs'] as $path) {
    if (! is_dir($runtime.'/'.$path)) {
        mkdir($runtime.'/'.$path, 0777, true);
    }
}
// The shared favicon view reads asset metadata; retain isolated writable public
// storage while supplying the same checked-in assets used by the application.
foreach (['favicon.ico', 'images/favicon-16x16.png', 'images/favicon-32x32.png', 'images/favicon-180x180.png'] as $asset) {
    copy($root.'/public/'.$asset, $runtime.'/public/'.$asset);
}
// Never load the checkout's environment, configuration cache or runtime files.
foreach (['APP_CONFIG_CACHE' => 'config.php', 'APP_SERVICES_CACHE' => 'services.php', 'APP_PACKAGES_CACHE' => 'packages.php'] as $key => $file) {
    $value = 'tests/.runtime/bootstrap/'.$file;
    putenv($key.'='.$value);
    $_ENV[$key] = $_SERVER[$key] = $value;
}
$loader = require $root.'/vendor/autoload.php';
$loader->setPsr4('Tests\\', __DIR__);
function createTurnstileTestApplication(): \Illuminate\Foundation\Application
{
    $app = require dirname(__DIR__).'/bootstrap/app.php';
    $app->useEnvironmentPath(__DIR__.'/.runtime/environment');
    $app->useStoragePath(__DIR__.'/.runtime/storage');
    $app->usePublicPath(__DIR__.'/.runtime/public');

    return $app;
}
require __DIR__.'/TurnstileTestCase.php';
