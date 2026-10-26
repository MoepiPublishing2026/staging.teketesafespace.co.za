<?php

namespace Tests;

abstract class TurnstileTestCase extends \Illuminate\Foundation\Testing\TestCase
{
    public function createApplication()
    {
        $app = createTurnstileTestApplication();
        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    protected function setUp(): void
    {
        parent::setUp();
        if (config('database.default') !== 'sqlite' || config('database.connections.sqlite.database') !== ':memory:') {
            throw new \RuntimeException('Report tests require isolated in-memory SQLite.');
        }
        config(['turnstile.site_key' => 'test-site', 'turnstile.secret_key' => 'test-secret',
            'turnstile.hostnames' => ['reports.test']]);
        \Illuminate\Support\Facades\Http::preventStrayRequests();
        (require __DIR__.'/report-fixture.php')();
    }
}
