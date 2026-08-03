<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$cols = Illuminate\Support\Facades\Schema::getColumnListing('schools');
echo implode("\n", $cols) . "\n\n";

$sample = Illuminate\Support\Facades\DB::table('schools')->limit(3)->get();
foreach ($sample as $s) {
    echo json_encode($s) . "\n";
}
