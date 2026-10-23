<?php

namespace Tests\Turnstile;

use App\Livewire\ReportForm;
use App\Services\ReportSubmissionLimiter;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;
use Livewire\Livewire;
use Tests\TurnstileTestCase;

class RateLimitsTest extends TurnstileTestCase
{
    public function test_session_limit_is_atomic_and_blocking_does_not_extend_window(): void
    {
        $this->travelTo(now()->startOfHour()->addMinutes(2));
        $this->assertSame(3, config('report_limits.session_attempts'));
        $this->assertSame(300, config('report_limits.ip_attempts'));
        $limiter = app(ReportSubmissionLimiter::class);
        for ($i = 0; $i < 3; $i++) {
            $limiter->admit('fixture-session', '192.0.2.1');
        }
        $before = DB::table('cache')->orderBy('key')->get()->toArray();
        try {
            $limiter->admit('fixture-session', '192.0.2.1');
            $this->fail('Expected blocking');
        } catch (ValidationException $error) {
            $this->assertStringContainsString('8 minutes 0 seconds', $error->getMessage());
        }
        $this->assertEquals($before, DB::table('cache')->orderBy('key')->get()->toArray());
        $this->travel(8)->minutes();
        $limiter->admit('fixture-session', '192.0.2.1');
        $this->assertTrue(true, 'Admission resumes at the aligned boundary.');
    }

    public function test_shared_ip_and_rejected_new_session_do_not_consume_either_allowance(): void
    {
        config(['report_limits.ip_attempts' => 3]);
        $limiter = app(ReportSubmissionLimiter::class);
        foreach (['one', 'two', 'three'] as $session) {
            $limiter->admit($session, '192.0.2.1');
        }
        $before = DB::table('cache')->orderBy('key')->get()->toArray();
        try {
            $limiter->admit('new-session', '192.0.2.1');
            $this->fail('Expected IP blocking');
        } catch (ValidationException) {
            $this->assertEquals($before, DB::table('cache')->orderBy('key')->get()->toArray());
        }
        $limiter->admit('new-session', '192.0.2.2');
        $this->assertTrue(true);
    }

    public function test_invalid_submissions_count_but_field_updates_do_not_and_blocking_preserves_fields(): void
    {
        Mail::fake();
        $form = Livewire::test(ReportForm::class, ['abuseTypeID' => 1, 'isAnonymous' => 'anonymous'])
            ->set('reporterEmail', 'fictional@example.com');
        $this->assertDatabaseCount('cache', 0);
        for ($i = 0; $i < 3; $i++) {
            $form->call('submitReport')->assertHasErrors('subtypeID');
        }
        $form->call('submitReport')->assertHasErrors('reportSubmission')
            ->assertSet('reporterEmail', 'fictional@example.com')->assertDispatched('report-verification-reset');
        $this->travel(10)->minutes();
        $form->call('submitReport')->assertHasErrors('subtypeID')->assertHasNoErrors('reportSubmission')
            ->assertSet('reporterEmail', 'fictional@example.com');
        $this->assertDatabaseCount('reports', 0);
        Http::assertNothingSent();
        Mail::assertNothingOutgoing();
    }

    public function test_storage_failure_blocks_safely_without_external_calls(): void
    {
        Schema::drop('cache');
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('temporarily unavailable');
        app(ReportSubmissionLimiter::class)->admit('one', '192.0.2.1');
    }

    public function test_lock_timeout_blocks_without_consuming_quota(): void
    {
        $lock = Cache::store('database')->lock('report-attempts:admission', 5);
        $this->assertTrue($lock->get());
        try {
            app(ReportSubmissionLimiter::class)->admit('one', '192.0.2.1');
            $this->fail('Expected lock timeout');
        } catch (ValidationException $error) {
            $this->assertStringContainsString('temporarily unavailable', $error->getMessage());
            $this->assertDatabaseCount('cache', 0);
        } finally {
            $lock->release();
        }
    }

    public function test_untrusted_forwarded_headers_do_not_bypass_the_ip_limit(): void
    {
        config(['report_limits.ip_attempts' => 1]);
        Mail::fake();
        foreach (['203.0.113.1', '203.0.113.2'] as $index => $spoofedIp) {
            $form = Livewire::withHeaders(['X-Forwarded-For' => $spoofedIp, 'CF-Connecting-IP' => $spoofedIp])
                ->test(ReportForm::class, ['abuseTypeID' => 1, 'isAnonymous' => 'anonymous'])->call('submitReport');
            $form->assertHasErrors($index === 0 ? 'subtypeID' : 'reportSubmission');
        }
        $this->assertDatabaseCount('reports', 0);
        Http::assertNothingSent();
        Mail::assertNothingOutgoing();
    }

    public function test_acquisition_deadlock_retries_without_double_counting(): void
    {
        $cache = Cache::store('database');
        $lock = \Mockery::mock(\Illuminate\Cache\DatabaseLock::class);
        $lock->shouldReceive('betweenBlockedAttemptsSleepFor')->once()->with(10)->andReturnSelf();
        $calls = 0;
        $lock->shouldReceive('block')->twice()->with(3)->andReturnUsing(function () use (&$calls) {
            if (++$calls === 1) {
                throw $this->fixtureDeadlock();
            }

            return true;
        });
        $lock->shouldReceive('release')->once()->andReturn(true);
        $proxy = \Mockery::mock($cache);
        $proxy->shouldReceive('lock')->once()->with('report-attempts:admission', 5)->andReturn($lock);
        Cache::shouldReceive('store')->once()->with('database')->andReturn($proxy);
        app(ReportSubmissionLimiter::class)->admit('retry-session', '192.0.2.1');
        $this->assertSingleAdmission($cache);
    }

    public function test_release_failure_does_not_replay_or_reject_a_committed_admission(): void
    {
        $cache = Cache::store('database');
        $lock = \Mockery::mock(\Illuminate\Cache\DatabaseLock::class);
        $lock->shouldReceive('betweenBlockedAttemptsSleepFor')->once()->andReturnSelf();
        $lock->shouldReceive('block')->once()->with(3)->andReturn(true);
        $lock->shouldReceive('release')->once()->andThrow($this->fixtureDeadlock());
        $proxy = \Mockery::mock($cache);
        $proxy->shouldReceive('lock')->once()->andReturn($lock);
        Cache::shouldReceive('store')->once()->with('database')->andReturn($proxy);
        app(ReportSubmissionLimiter::class)->admit('release-session', '192.0.2.1');
        $this->assertSingleAdmission($cache);
    }

    private function fixtureDeadlock(): \Illuminate\Database\QueryException
    {
        $exception = new \PDOException('Fixture deadlock', 40001);
        $exception->errorInfo = ['40001', 1213, 'Fixture deadlock'];

        return new \Illuminate\Database\QueryException('sqlite', 'fixture statement', [], $exception);
    }

    private function assertSingleAdmission($cache): void
    {
        $this->assertDatabaseCount('cache', 2);
        foreach (DB::table('cache')->pluck('key') as $key) {
            $this->assertSame(1, $cache->get(substr($key, strlen($cache->getStore()->getPrefix()))));
        }
    }
}
