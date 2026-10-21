<?php

namespace App\Services\Reports;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ReportSubmissionLimiter
{
    public function admit(string $sessionId, string $ip): void
    {
        $store = Cache::store('database');
        $config = config('report_protection');
        $rules = [];
        foreach (['session' => $sessionId, 'ip' => $ip] as $kind => $value) {
            $identity = hash_hmac('sha256', $kind.':'.$value, config('app.key'));
            foreach (['burst', 'sustained'] as $window) {
                $seconds = max(1, (int) $config[$window.'_seconds']);
                $bucket = intdiv(now()->getTimestamp(), $seconds);
                $rules[] = ['report-submit:'.$identity.':'.$window.':'.$bucket,
                    max(1, (int) $config[$kind.'_'.$window]), $seconds];
            }
        }
        usort($rules, fn ($a, $b) => strcmp($a[0], $b[0]));

        // A short supported database-cache lock coordinates workers. The transaction
        // prevents partial multi-window admission. No HTTP/files/mail in this lock.
        $store->lock('report-submit:admission', 5)->betweenBlockedAttemptsSleepFor(10)->block(1, function () use ($store, $rules) {
            DB::connection(config('cache.stores.database.connection'))->transaction(function () use ($store, $rules) {
                $counts = [];
                // DatabaseStore::increment locks each row until this transaction
                // commits. Ordered row locks also protect a delayed worker after
                // the outer cache-lock lease expires, using supported cache APIs.
                foreach ($rules as [$key, $limit, $seconds]) {
                    $store->add($key, 0, $seconds + 1);
                    $counts[$key] = $store->increment($key, 0);
                    if ($counts[$key] === false) {
                        throw new \RuntimeException('Submission limiter storage unavailable.');
                    }
                    if ($counts[$key] >= $limit) {
                        throw ValidationException::withMessages([
                            'reportSubmission' => 'Too many submission attempts. Please wait before trying again. Your entries are preserved.',
                        ]);
                    }
                }
                foreach ($rules as [$key, $limit, $seconds]) {
                    if ($store->increment($key) === false) {
                        throw new \RuntimeException('Submission limiter storage unavailable.');
                    }
                }
            }, 3);
        });
    }
}
