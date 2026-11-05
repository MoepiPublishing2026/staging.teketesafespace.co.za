<?php

namespace App\Services;

use Illuminate\Cache\DatabaseStore;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ReportSubmissionLimiter
{
    public function admit(string $sessionId, string $ip): void
    {
        try {
            $limits = config('report_limits');
            if ($sessionId === '' || $ip === '' || empty(config('app.key'))
                || min($limits['session_attempts'], $limits['ip_attempts'], $limits['window_seconds']) < 1) {
                throw new \RuntimeException('Invalid limiter configuration.');
            }
            $cache = Cache::store('database');
            if (! $cache->getStore() instanceof DatabaseStore) {
                throw new \RuntimeException('Database cache required.');
            }
            // Short global admission lock only. Row locks below remain authoritative
            // if a delayed worker outlives this lease. No report or HTTP work here.
            $lock = $cache->lock('report-attempts:admission', 5)->betweenBlockedAttemptsSleepFor(10);
            // Duplicate-key contention in DatabaseLock acquisition can deadlock on
            // InnoDB. Retry acquisition only, never an already committed admission.
            retry(3, fn () => $lock->block(3), 50, fn ($error) => $error instanceof \Illuminate\Database\QueryException
                && (($error->errorInfo[0] ?? null) === '40001'
                    || in_array((int) ($error->errorInfo[1] ?? 0), [1205, 1213], true)));
            try {
                DB::connection(config('cache.stores.database.connection'))->transaction(function () use ($cache, $limits, $sessionId, $ip) {
                    $seconds = $limits['window_seconds'];
                    $timestamp = now()->getTimestamp();
                    $bucket = intdiv($timestamp, $seconds);
                    $wait = ($bucket + 1) * $seconds - $timestamp;
                    $rules = [];
                    foreach (['session' => $sessionId, 'ip' => $ip] as $kind => $identity) {
                        $hash = hash_hmac('sha256', $kind.':'.$identity, config('app.key'));
                        $rules['report-attempts:'.$seconds.':'.$bucket.':'.$hash] = $limits[$kind.'_attempts'];
                    }
                    ksort($rules);
                    foreach ($rules as $key => $maximum) {
                        $cache->add($key, 0, $wait + 1);
                        // Supported DatabaseStore API acquires a transaction row lock.
                        $count = $cache->increment($key, 0);
                        if ($count === false) {
                            throw new \RuntimeException('Counter storage unavailable.');
                        }
                        if ($count >= $maximum) {
                            $minutes = intdiv($wait, 60);
                            $remaining = $wait % 60;
                            $duration = ($minutes ? $minutes.' minute'.($minutes === 1 ? '' : 's').' ' : '')
                                .$remaining.' second'.($remaining === 1 ? '' : 's');
                            throw ValidationException::withMessages(['reportSubmission' => 'Too many submission attempts. Please try again in '.$duration.'. Your entered information and uploads are preserved.']);
                        }
                    }
                    foreach ($rules as $key => $maximum) {
                        if ($cache->increment($key) === false) {
                            throw new \RuntimeException('Counter storage unavailable.');
                        }
                    }
                }, 3);
            } finally {
                try {
                    $lock->release();
                } catch (\Throwable $error) {
                    // Counters have already committed or rolled back. Do not replay
                    // admission or turn a committed allowance into a false failure.
                    // The lease expires; counter row locks remain authoritative.
                    $this->logUnavailable($error);
                }
            }
        } catch (ValidationException $error) {
            throw $error;
        } catch (\Throwable $error) {
            $this->logUnavailable($error);
            throw ValidationException::withMessages(['reportSubmission' => 'Submission is temporarily unavailable. Your entered information and uploads are preserved. Please try again shortly.']);
        }
    }

    private function logUnavailable(\Throwable $error): void
    {
        try {
            Log::warning('Report admission unavailable.', ['error_type' => $error::class,
                'sqlstate' => $error instanceof \Illuminate\Database\QueryException ? ($error->errorInfo[0] ?? null) : null,
                'driver_code' => $error instanceof \Illuminate\Database\QueryException ? ($error->errorInfo[1] ?? null) : null]);
        } catch (\Throwable) {
            // Logging availability must not change admission's outcome.
        }
    }
}
