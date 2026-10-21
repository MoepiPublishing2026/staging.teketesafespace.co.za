<?php

$root = dirname(__DIR__);
$runtime = __DIR__.'/.runtime';
foreach (['environment', 'bootstrap', 'public', 'storage/framework/views', 'storage/framework/cache/data', 'storage/framework/sessions', 'storage/logs'] as $path) {
    if (! is_dir($runtime.'/'.$path)) {
        mkdir($runtime.'/'.$path, 0777, true);
    }
}
// Never load the checkout's environment, configuration cache or runtime files.
foreach (['APP_CONFIG_CACHE' => 'config.php', 'APP_SERVICES_CACHE' => 'services.php', 'APP_PACKAGES_CACHE' => 'packages.php'] as $key => $file) {
    $value = 'tests/.runtime/bootstrap/'.$file;
    putenv($key.'='.$value);
    $_ENV[$key] = $_SERVER[$key] = $value;
}
$vendor = getenv('REPORT_TEST_VENDOR') ?: $root.'/vendor';
if (! is_file($vendor.'/autoload.php')) {
    throw new RuntimeException('Set REPORT_TEST_VENDOR to an installed vendor directory for this isolated worktree.');
}
$loader = require $vendor.'/autoload.php';
$loader->setPsr4('Tests\\', __DIR__);
$loader->setPsr4('App\\', $root.'/app');
// A borrowed optimized vendor tree may contain class-map entries for its original
// checkout. Override only application classes so tests exercise this worktree.
foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root.'/app')) as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $relative = substr($file->getPathname(), strlen($root.'/app') + 1, -4);
        $loader->addClassMap(['App\\'.str_replace(['/', '\\'], '\\', $relative) => $file->getPathname()]);
    }
}
function createReportTestApplication(): \Illuminate\Foundation\Application
{
    $app = require dirname(__DIR__).'/bootstrap/app.php';
    $app->useEnvironmentPath(__DIR__.'/.runtime/environment');
    $app->useStoragePath(__DIR__.'/.runtime/storage');
    $app->usePublicPath(__DIR__.'/.runtime/public');

    return $app;
}
require __DIR__.'/ReportTestCase.php';
