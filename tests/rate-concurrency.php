<?php

// CLI-only, explicit opt-in, random disposable schema, no application .env load.
if (PHP_SAPI !== 'cli' || getenv('REPORT_RATE_TEST_ENABLE') !== '1') {
    exit("Set REPORT_RATE_TEST_ENABLE=1 and loopback test credentials explicitly.\n");
}
$host = getenv('REPORT_RATE_TEST_HOST') ?: '127.0.0.1';
if ($host !== '127.0.0.1') {
    throw new RuntimeException('Only loopback test servers are allowed.');
}
$database = $argv[2] ?? 'report_rate_test_'.bin2hex(random_bytes(6));
if (! preg_match('/^report_rate_test_[a-f0-9]{12}$/', $database)) {
    throw new RuntimeException('Unsafe database name.');
}
foreach (['APP_ENV' => 'testing', 'APP_KEY' => 'base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=', 'DB_CONNECTION' => 'sqlite', 'DB_DATABASE' => ':memory:', 'DB_URL' => '', 'SESSION_DRIVER' => 'array', 'CACHE_STORE' => 'array', 'MAIL_MAILER' => 'array', 'QUEUE_CONNECTION' => 'sync', 'LOG_CHANNEL' => 'null'] as $key => $value) {
    putenv($key.'='.$value);
    $_ENV[$key] = $_SERVER[$key] = $value;
}
require __DIR__.'/bootstrap.php';
$app = createTurnstileTestApplication();
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
set_exception_handler(function (Throwable $error) {
    fwrite(STDERR, 'Isolated rate test failed: '.$error::class."\n");
    if ($error instanceof RuntimeException && ! $error instanceof PDOException && ! $error instanceof Illuminate\Database\QueryException) {
        fwrite(STDERR, $error->getMessage()."\n");
    }
    exit(1);
});

use App\Livewire\ReportForm;
use App\Services\ReportSubmissionLimiter;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Livewire\Livewire;

$port = (int) (getenv('REPORT_RATE_TEST_PORT') ?: 3306);
$username = getenv('REPORT_RATE_TEST_USER');
$password = getenv('REPORT_RATE_TEST_PASSWORD') ?: '';
if ($username === false) {
    throw new RuntimeException('Explicit test username required.');
}
config(['database.default' => 'mysql', 'database.connections.mysql' => [
    'driver' => 'mysql', 'host' => $host, 'port' => $port, 'database' => $database,
    'username' => $username, 'password' => $password, 'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci', 'prefix' => '', 'strict' => true,
], 'cache.stores.database.connection' => 'mysql', 'cache.stores.database.lock_connection' => 'mysql',
    'cache.prefix' => 'isolated-rate-test:', 'report_limits.session_attempts' => 3,
    'report_limits.ip_attempts' => 300, 'report_limits.window_seconds' => 600,
    'turnstile.site_key' => 'fixture-site', 'turnstile.secret_key' => 'fixture-secret',
    'turnstile.hostnames' => ['reports.test'],
]);
Cache::purge('database');
Carbon\Carbon::setTestNow('2026-10-23 12:02:00 UTC');
Http::preventStrayRequests();
Mail::fake();
$limiter = app(ReportSubmissionLimiter::class);
if (($argv[1] ?? 'parent') === 'worker') {
    Illuminate\Support\Facades\Log::shouldReceive('warning')->andReturnUsing(function ($message, $context) {
        fwrite(STDERR, 'Limiter failure class: '.($context['error_type'] ?? 'unknown').' SQLSTATE '.($context['sqlstate'] ?? 'none').' DRIVER '.($context['driver_code'] ?? 'none')."\n");
    });
    $phase = $argv[3];
    $index = (int) $argv[4];
    while (microtime(true) < (float) getenv('REPORT_RATE_TEST_START')) {
        usleep(10000);
    }
    try {
        $limiter->admit($phase === 'session' ? 'same-session' : ($phase === 'shared' ? 'shared-'.($index % 6) : 'new-'.$index), '192.0.2.1');
        exit(0);
    } catch (ValidationException $error) {
        exit(str_contains($error->getMessage(), 'Too many') ? 2 : 3);
    }
}

function checkRate(bool $condition, string $message): void
{
    if (! $condition) {
        throw new RuntimeException($message);
    }
}
function counters(): array
{
    $values = [];
    foreach (DB::table('cache')->orderBy('key')->pluck('key') as $key) {
        $values[] = Cache::store('database')->get(substr($key, strlen(config('cache.prefix'))));
    }

    return $values;
}
function fictionalForm()
{
    return Livewire::test(ReportForm::class, ['abuseTypeID' => 1, 'isAnonymous' => 'anonymous'])
        ->set('subtypeID', 1)->set('reporterEmail', 'fictional@example.com')->set('phoneNumber', '0821234567')
        ->set('age', 10)->set('grade', 'Grade 4')->set('location', '123 Test Street, Gauteng')
        ->set('schoolName', 'Test School')->set('schoolId', 1)->set('fullName', 'Fictional Person');
}

$pdo = new PDO('mysql:host='.$host.';port='.$port, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$pdo->exec('CREATE DATABASE `'.$database.'` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
try {
    echo 'Disposable database created; engine '.$pdo->query('SELECT VERSION()')->fetchColumn()."\n";
    (require __DIR__.'/report-fixture.php')();
    $engines = DB::table('information_schema.TABLES')->where('TABLE_SCHEMA', $database)
        ->whereIn('TABLE_NAME', ['cache', 'cache_locks'])->pluck('ENGINE')->all();
    checkRate(count($engines) === 2 && count(array_filter($engines, fn ($engine) => strtoupper($engine) === 'INNODB')) === 2, 'Transactional InnoDB cache tables required');
    foreach (['session' => [8, 3], 'ip' => [8, 1], 'shared' => [12, 12]] as $phase => [$workers, $expected]) {
        if (getenv('REPORT_RATE_TEST_PHASE') && getenv('REPORT_RATE_TEST_PHASE') !== $phase) {
            continue;
        }
        Cache::store('database')->flush();
        if ($phase === 'ip') {
            for ($i = 0; $i < 299; $i++) {
                $limiter->admit('seed-'.$i, '192.0.2.1');
            }
        }
        putenv('REPORT_RATE_TEST_START='.(microtime(true) + 3));
        $processes = [];
        try {
            for ($i = 0; $i < $workers; $i++) {
                $process = proc_open([PHP_BINARY, __FILE__, 'worker', $database, $phase, (string) $i], [0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w']], $pipes, dirname(__DIR__), null, ['bypass_shell' => true]);
                if (! is_resource($process)) {
                    throw new RuntimeException('Could not launch isolated worker');
                }
                fclose($pipes[0]);
                $processes[] = [$process, $pipes];
            }
            $accepted = 0;
            foreach ($processes as [$process, $pipes]) {
                stream_get_contents($pipes[1]);
                $workerError = stream_get_contents($pipes[2]);
                fclose($pipes[1]);
                fclose($pipes[2]);
                $code = proc_close($process);
                checkRate(in_array($code, [0, 2], true), 'Worker exit '.$code.' in '.$phase.'; '.(preg_match('/Limiter failure class: [A-Za-z\\\\]+ SQLSTATE [A-Za-z0-9]+ DRIVER [A-Za-z0-9]+/', $workerError, $match) ? $match[0] : 'no sanitized exception class'));
                $accepted += (int) ($code === 0);
            }
            $processes = [];
            checkRate($accepted === $expected, 'Concurrent quota mismatch');
            $counts = counters();
            $sum = array_sum($counts);
            checkRate($sum === ($phase === 'ip' ? 600 : 2 * $expected), 'Counters partially consumed or exceeded quota');
            checkRate(count($counts) === ($phase === 'session' ? 2 : ($phase === 'ip' ? 301 : 7)), 'Rejected sessions left counter rows');
            echo "$phase concurrency: $accepted/$workers accepted; counters verified.\n";
        } finally {
            foreach ($processes as [$process, $pipes]) {
                if (is_resource($process)) {
                    proc_terminate($process);
                    foreach ($pipes as $pipe) {
                        if (is_resource($pipe)) {
                            fclose($pipe);
                        }
                    }
                    proc_close($process);
                }
            }
        }
    }

    Cache::store('database')->flush();
    Storage::fake('public');
    Http::fake(['*' => Http::response(['success' => false, 'error-codes' => ['invalid-input-response']])]);
    $form = fictionalForm()->set('image', [Illuminate\Http\UploadedFile::fake()->create('fictional.pdf', 1, 'application/pdf')]);
    checkRate(DB::table('cache')->count() === 0, 'Field updates counted as submissions');
    for ($i = 0; $i < 3; $i++) {
        $form->set('turnstileToken', 'fixture-token')->call('submitReport')->assertHasErrors('turnstileToken');
    }
    $snapshot = DB::table('cache')->orderBy('key')->get()->toArray();
    $form->set('turnstileToken', 'fresh-fixture')->call('submitReport')->assertHasErrors('reportSubmission')
        ->assertSet('reporterEmail', 'fictional@example.com')->assertDispatched('report-verification-reset');
    checkRate($form->get('image')[0]->exists(), 'Temporary upload lost');
    checkRate($snapshot == DB::table('cache')->orderBy('key')->get()->toArray(), 'Blocked attempt changed counts/expiry');
    checkRate(DB::table('reports')->count() === 0 && Storage::disk('public')->allFiles() === [], 'Blocked submission had permanent side effects');
    Http::assertSentCount(3);
    Mail::assertNothingOutgoing();
    echo "MySQL Livewire: failed CAPTCHA consumes attempts; blocked draft/upload preserved; no report, file or email.\n";

    Cache::store('database')->flush();
    Http::swap(new Illuminate\Http\Client\Factory);
    Http::preventStrayRequests();
    Http::fake(function () {
        $lock = Cache::store('database')->lock('report-attempts:admission', 5);
        checkRate($lock->get(), 'External HTTP executed inside admission lock');
        $lock->release();

        return Http::response(['success' => true, 'hostname' => 'reports.test', 'action' => 'report_submit']);
    });
    fictionalForm()->set('turnstileToken', 'fixture-token')->call('submitReport')->assertHasNoErrors();
    checkRate(DB::table('reports')->count() === 1, 'Valid report did not save');
    Mail::assertSentCount(1);
    echo "MySQL Livewire: valid submission and mocked mail pass; external verification occurs outside lock.\n";

    Cache::store('database')->flush();
    Carbon\Carbon::setTestNow('2026-10-23 12:09:59 UTC');
    for ($i = 0; $i < 3; $i++) {
        $limiter->admit('boundary-session', '192.0.2.2');
    }
    try {
        $limiter->admit('boundary-session', '192.0.2.2');
        throw new RuntimeException('Expected boundary rejection');
    } catch (ValidationException $error) {
        checkRate(str_contains($error->getMessage(), '1 second'), 'Incorrect wait duration');
    }
    Carbon\Carbon::setTestNow('2026-10-23 12:10:00 UTC');
    $limiter->admit('boundary-session', '192.0.2.2');
    echo "MySQL aligned window: one-second wait and admission at next boundary pass.\n";

    // Laravel's lock timeout uses now(); restore the real clock before timing it.
    Carbon\Carbon::setTestNow();
    Cache::store('database')->flush();
    $lock = Cache::store('database')->lock('report-attempts:admission', 5);
    checkRate($lock->get(), 'Could not acquire test lock');
    try {
        $limiter->admit('locked', '192.0.2.3');
        throw new RuntimeException('Expected lock timeout');
    } catch (ValidationException $error) {
        checkRate(str_contains($error->getMessage(), 'temporarily unavailable') && DB::table('cache')->count() === 0, 'Unsafe lock failure');
    } finally {
        $lock->release();
    }
    Schema::drop('cache');
    try {
        $limiter->admit('storage-failure', '192.0.2.3');
        throw new RuntimeException('Expected storage failure');
    } catch (ValidationException $error) {
        checkRate(str_contains($error->getMessage(), 'temporarily unavailable'), 'Unsafe storage failure');
    }
    echo "MySQL lock timeout/storage failure: fail closed without consuming quota.\n";
} finally {
    DB::disconnect('mysql');
    $pdo->exec('DROP DATABASE `'.$database.'`');
    echo "Disposable database dropped.\n";
}
