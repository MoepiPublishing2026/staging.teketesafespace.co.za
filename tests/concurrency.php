<?php

// Explicit opt-in; only a disposable server on this nonstandard loopback port.
if (PHP_SAPI !== 'cli' || getenv('REPORT_CONCURRENCY_ENABLE') !== '1') {
    if (PHP_SAPI === 'cli') {
        fwrite(STDERR, "Set REPORT_CONCURRENCY_ENABLE=1 for an isolated MySQL server on 127.0.0.1:33317.\n");
    }
    exit(1);
}
putenv('APP_ENV=testing');
putenv('DB_CONNECTION=sqlite');
putenv('DB_DATABASE=:memory:');
putenv('APP_KEY=base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=');
putenv('LOG_CHANNEL=null');
require __DIR__.'/bootstrap.php';
$app = createReportTestApplication();
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
set_exception_handler(function (Throwable $error) {
    fwrite(STDERR, 'Concurrency check failed: '.$error::class."\n");
    if ($error instanceof Illuminate\Database\QueryException) {
        fwrite(STDERR, 'SQLSTATE '.($error->errorInfo[0] ?? '').' driver code '.($error->errorInfo[1] ?? '')."\n");
    }
    exit(1);
});
$mode = $argv[1] ?? 'parent';
$database = $argv[2] ?? 'report_protection_test_'.bin2hex(random_bytes(5));
if (! preg_match('/^report_protection_test_[a-f0-9]{10}$/', $database)) {
    throw new RuntimeException('Unsafe test database name.');
}
config(['database.default' => 'mysql', 'database.connections.mysql' => [
    'driver' => 'mysql', 'host' => '127.0.0.1', 'port' => 33317,
    'database' => $database, 'username' => 'root', 'password' => '',
    'charset' => 'utf8mb4', 'collation' => 'utf8mb4_unicode_ci', 'prefix' => '', 'strict' => true,
], 'cache.stores.database.connection' => 'mysql', 'cache.stores.database.lock_connection' => 'mysql',
    'report_protection.session_burst' => 3, 'report_protection.session_sustained' => 30,
]);
Illuminate\Support\Facades\Cache::purge('database');
Carbon\Carbon::setTestNow('2026-10-21 12:34:00 UTC');

if ($mode === 'limit') {
    try {
        app(App\Services\Reports\ReportSubmissionLimiter::class)->admit('same-session', '192.0.2.1');
        exit(0);
    } catch (Illuminate\Validation\ValidationException) {
        exit(2);
    }
}
if ($mode === 'save' || $mode === 'conflict') {
    $service = app(App\Services\Reports\ReportSubmission::class);
    $identity = $service->decode(file_get_contents(__DIR__.'/.runtime/concurrency-identity'), 'same-session');
    $payload = $mode === 'conflict' && ((int) ($argv[3] ?? 0)) % 2 === 1 ? 'changed-payload' : 'same-payload';
    try {
        $service->save($identity, hash('sha256', $payload), function () {
            usleep(100000);

            return App\Models\Report::create(['case_number' => 'CASE-CONCURRENT']);
        });
    } catch (Illuminate\Validation\ValidationException) {
        exit(2);
    }
    exit(0);
}

$pdo = new PDO('mysql:host=127.0.0.1;port=33317', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$pdo->exec('CREATE DATABASE `'.$database.'`');
try {
    (require database_path('migrations/0001_01_01_000001_create_cache_table.php'))->up();
    (require database_path('migrations/2026_10_21_000001_create_report_submissions_table.php'))->up();
    Illuminate\Support\Facades\Schema::create('reports', function ($table) {
        $table->id();
        $table->string('case_number')->unique();
        $table->timestamps();
    });
    file_put_contents(__DIR__.'/.runtime/concurrency-identity', app(App\Services\Reports\ReportSubmission::class)->identity('same-session'));
    foreach (['limit', 'save', 'conflict'] as $phase) {
        $processes = [];
        for ($i = 0; $i < 8; $i++) {
            $log = __DIR__.'/.runtime/'.$phase.'-'.$i.'.log';
            $processes[] = proc_open([PHP_BINARY, __FILE__, $phase, $database, (string) $i],
                [0 => ['pipe', 'r'], 1 => ['file', $log, 'w'], 2 => ['file', $log, 'a']], $pipes);
            fclose($pipes[0]);
        }
        $codes = array_map(fn ($process) => proc_close($process), $processes);
        $admitted = count(array_filter($codes, fn ($code) => $code === 0));
        echo $phase.' worker exit codes: '.implode(',', $codes)."\n";
        if ($phase === 'limit') {
            if ($admitted !== 3 || count(array_filter($codes, fn ($code) => $code === 2)) !== 5) {
                throw new RuntimeException('Concurrent limiter assertion failed; inspect ignored runtime logs.');
            }
            $counters = Illuminate\Support\Facades\DB::table('cache')->pluck('value');
            if ($counters->count() !== 4 || $counters->contains(fn ($value) => unserialize($value) !== 3)) {
                throw new RuntimeException('Concurrent counters did not commit exactly three admissions.');
            }
            echo "MySQL concurrent limiter: exactly 3/8 admitted, 5 rejected.\n";
        } elseif ($phase === 'conflict') {
            if ($admitted !== 4 || count(array_filter($codes, fn ($code) => $code === 2)) !== 4 || App\Models\Report::count() !== 1) {
                throw new RuntimeException('Concurrent changed-payload assertion failed.');
            }
            echo "MySQL concurrent changed payloads: 4 original results, 4 conflicts, still 1 report.\n";
        } elseif ($admitted !== 8 || App\Models\Report::count() !== 1 || Illuminate\Support\Facades\DB::table('report_submissions')->count() !== 1) {
            throw new RuntimeException('Concurrent duplicate assertion failed; inspect ignored runtime logs.');
        } else {
            echo "MySQL concurrent duplicate saves: 8 successful results, 1 report, 1 durable claim.\n";
        }
    }
} finally {
    Illuminate\Support\Facades\DB::disconnect('mysql');
    $pdo->exec('DROP DATABASE `'.$database.'`');
}
