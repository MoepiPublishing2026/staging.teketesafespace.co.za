<?php

namespace Tests\Turnstile;

use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase
{
    public function test_environment_variable_names_map_to_the_verifier_configuration(): void
    {
        $values = ['TURNSTILE_SITE_KEY' => 'fixture-site', 'TURNSTILE_SECRET' => 'fixture-secret'];
        $original = [];
        foreach ($values as $key => $value) {
            $original[$key] = [$_ENV[$key] ?? null, $_SERVER[$key] ?? null, getenv($key)];
            $_ENV[$key] = $_SERVER[$key] = $value;
            putenv($key.'='.$value);
        }

        try {
            $config = require dirname(__DIR__, 2).'/config/turnstile.php';
            $this->assertSame('fixture-site', $config['site_key']);
            $this->assertSame('fixture-secret', $config['secret_key']);
        } finally {
            foreach ($original as $key => [$env, $server, $process]) {
                unset($_ENV[$key], $_SERVER[$key]);
                if ($env !== null) {
                    $_ENV[$key] = $env;
                }
                if ($server !== null) {
                    $_SERVER[$key] = $server;
                }
                putenv($process === false ? $key : $key.'='.$process);
            }
        }
    }
}
