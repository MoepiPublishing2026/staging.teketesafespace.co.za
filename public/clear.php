<?php

use Illuminate\Support\Facades\Artisan;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo "Clearing config... ";
echo $kernel->call('config:clear') . "<br>";

echo "Clearing cache... ";
echo $kernel->call('cache:clear') . "<br>";

echo "Clearing route cache... ";
echo $kernel->call('route:clear') . "<br>";

echo "Clearing view cache... ";
echo $kernel->call('view:clear') . "<br>";

echo "Done!";
