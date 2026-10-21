<?php

$root = dirname(__DIR__);
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
foreach (['framework/views', 'framework/cache/data', 'framework/sessions', 'logs'] as $path) {
    if (! is_dir($root.'/storage/'.$path)) {
        mkdir($root.'/storage/'.$path, 0777, true);
    }
}
require __DIR__.'/ReportTestCase.php';
