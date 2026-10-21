<?php

namespace Tests\Reports;

use App\Livewire\ReportForm;
use App\Models\Report;
use App\Services\Reports\ReportSubmission;
use App\Services\Reports\ReportSubmissionLimiter;
use App\Services\Reports\TurnstileVerifier;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\ReportTestCase;

class ProtectionTest extends ReportTestCase
{
    private function validForm(bool $anonymous = true)
    {
        return Livewire::test(ReportForm::class, ['abuseTypeID' => 1,
            'isAnonymous' => $anonymous ? 'anonymous' : 'non-anonymous'])
            ->set('subtypeID', 1)->set('reporterEmail', 'reporter@example.com')
            ->set('phoneNumber', '0821234567')->set('age', 10)
            ->set('grade', 'Grade 4')->set('location', '123 Main Street, Gauteng')
            ->set('schoolName', 'Test School')->set('schoolId', 1)->set('fullName', 'Test Person');
    }

    private function allowVerification(): void
    {
        Http::fake(['challenges.cloudflare.com/*' => Http::response([
            'success' => true, 'hostname' => 'reports.test', 'action' => 'report_submit',
        ])]);
    }

    public function test_browser_fixture_can_render_actual_form(): void
    {
        $response = $this->get('/report-form/1/anonymous')->assertOk();
        $response->assertSee('Human verification')->assertSee('Complete verification above');
        $fixture = __DIR__.'/../.runtime/browser.sqlite';
        if (is_file($fixture)) {
            unlink($fixture);
        }
        DB::statement("VACUUM INTO '".str_replace("'", "''", str_replace('\\', '/', $fixture))."'");
    }

    public function test_valid_named_report_and_completed_retry_without_captcha(): void
    {
        $this->allowVerification();
        Mail::fake();
        $form = $this->validForm(false)->set('turnstileToken', 'valid')->call('submitReport')->assertHasNoErrors();
        $this->assertSame(1, Report::count());
        $case = Report::first()->case_number;
        \Illuminate\Support\Facades\Cache::store('database')->flush();
        $form->set('turnstileToken', '')->call('submitReport')->assertHasNoErrors();
        $this->assertSame(1, Report::count());
        $form->assertSee($case);
        Http::assertSentCount(1);
        Mail::assertSentCount(1);
    }

    public function test_starting_another_report_issues_a_new_identity(): void
    {
        $form = $this->validForm();
        $identity = $form->get('submissionIdentity');
        $form->call('startNewReport')->assertSet('reporterEmail', null)->assertSet('image', []);
        $this->assertNotSame($identity, $form->get('submissionIdentity'));
        app(ReportSubmission::class)->decode($form->get('submissionIdentity'), session()->getId());
    }

    public function test_email_failure_keeps_committed_report_successful(): void
    {
        $this->allowVerification();
        Mail::shouldReceive('to')->once()->andThrow(new \RuntimeException('transport failed'));
        $form = $this->validForm()->set('turnstileToken', 'valid')->call('submitReport')->assertHasNoErrors();
        $this->assertSame(1, Report::count());
        $form->assertSee(Report::first()->case_number)
            ->assertSee('Your report was saved, but the confirmation email could not be sent.')
            ->assertDontSee('Something went wrong. Please try again.');
    }

    public function test_direct_action_without_token_cannot_create_report_and_preserves_input(): void
    {
        Http::fake();
        Mail::fake();
        $this->validForm()->call('submitReport')->assertHasErrors('turnstileToken')
            ->assertSet('reporterEmail', 'reporter@example.com')->assertSet('schoolName', 'Test School');
        $this->assertSame(0, Report::count());
        Http::assertNothingSent();
        Mail::assertNothingSent();
    }

    public static function invalidVerification(): array
    {
        return [
            'expired/reused' => [['success' => false, 'error-codes' => ['timeout-or-duplicate']]],
            'wrong host' => [['success' => true, 'hostname' => 'attacker.test', 'action' => 'report_submit']],
            'wrong action' => [['success' => true, 'hostname' => 'reports.test', 'action' => 'login']],
            'malformed' => [['success' => 'true']],
        ];
    }

    #[DataProvider('invalidVerification')]
    public function test_invalid_verification_is_rejected(array $response): void
    {
        Http::fake(['*' => Http::response($response)]);
        try {
            app(TurnstileVerifier::class)->verify('token');
            $this->fail('Verification accepted');
        } catch (ValidationException $e) {
            $this->assertArrayHasKey('turnstileToken', $e->errors());
        }
        $this->assertSame(0, Report::count());
    }

    public function test_network_failure_is_recoverable(): void
    {
        Http::fake(fn () => throw new \Illuminate\Http\Client\ConnectionException('unreachable'));
        $this->validForm()->set('turnstileToken', 'token')->call('submitReport')
            ->assertHasErrors('turnstileToken')->assertSet('schoolName', 'Test School');
        $this->assertSame(0, Report::count());
    }

    public function test_invalid_verification_preserves_temporary_upload_and_writes_no_permanent_file(): void
    {
        Http::fake(['*' => Http::response(['success' => false])]);
        Mail::fake();
        Storage::fake('public');
        $form = $this->validForm()->set('image', [UploadedFile::fake()->create('evidence.pdf', 1, 'application/pdf')]);
        $temporary = $form->get('image')[0]->getRealPath();
        $form->set('turnstileToken', 'invalid')->call('submitReport')->assertHasErrors('turnstileToken');
        $this->assertFileExists($temporary);
        $this->assertCount(1, $form->get('image'));
        $this->assertSame([], Storage::disk('public')->allFiles());
        $this->assertSame(0, Report::count());
        Mail::assertNothingSent();
    }

    public function test_action_rate_limit_cannot_be_bypassed_by_valid_captcha(): void
    {
        config(['report_protection.session_burst' => 1]);
        $this->allowVerification();
        $form = $this->validForm()->call('submitReport')->assertHasErrors('turnstileToken');
        $form->set('turnstileToken', 'valid')->call('submitReport')->assertHasErrors('reportSubmission');
        $this->assertSame(0, Report::count());
        Http::assertNothingSent();
    }

    public function test_unconfigured_verification_fails_closed(): void
    {
        config(['report_protection.hostnames' => []]);
        Http::fake();
        $this->validForm()->set('turnstileToken', 'token')->call('submitReport')->assertHasErrors('turnstileToken');
        Http::assertNothingSent();
        $this->assertSame(0, Report::count());
    }

    public function test_limiter_storage_failure_fails_closed_and_preserves_input(): void
    {
        Http::fake();
        $form = $this->validForm();
        \Illuminate\Support\Facades\Schema::drop('cache_locks');
        $form->set('turnstileToken', 'token')->call('submitReport')
            ->assertHasErrors('reportSubmission')->assertSet('reporterEmail', 'reporter@example.com');
        Http::assertNothingSent();
        $this->assertSame(0, Report::count());
    }

    public function test_limit_window_expires_and_untrusted_forwarded_headers_do_not_set_ip(): void
    {
        config(['report_protection.session_burst' => 1]);
        $limiter = app(ReportSubmissionLimiter::class);
        $limiter->admit('one', '192.0.2.1');
        $this->travel(11)->minutes();
        $limiter->admit('one', '192.0.2.1');
        $this->travelBack();
        $request = \Illuminate\Http\Request::create('/', server: [
            'REMOTE_ADDR' => '192.0.2.1', 'HTTP_X_FORWARDED_FOR' => '198.51.100.1', 'HTTP_CF_CONNECTING_IP' => '198.51.100.1',
        ]);
        $request::setTrustedProxies([], $request::HEADER_X_FORWARDED_FOR);
        $this->assertSame('192.0.2.1', $request->ip());
    }

    public function test_limiter_bounds_and_shared_ip_sessions(): void
    {
        config(['report_protection.session_burst' => 1, 'report_protection.ip_burst' => 3]);
        $limiter = app(ReportSubmissionLimiter::class);
        $limiter->admit('one', '192.0.2.1');
        $limiter->admit('two', '192.0.2.1');
        try {
            $limiter->admit('one', '192.0.2.1');
            $this->fail('Session limit bypassed');
        } catch (ValidationException) {
            $this->assertTrue(true);
        }
        $limiter->admit('three', '192.0.2.1');
        $this->expectException(ValidationException::class);
        $limiter->admit('four', '192.0.2.1');
    }

    public function test_identity_is_session_bound_and_claim_rolls_back_with_failed_save(): void
    {
        $service = app(ReportSubmission::class);
        $envelope = $service->identity('one');
        $identity = $service->decode($envelope, 'one');
        try {
            $service->decode($envelope, 'two');
            $this->fail('Cross session accepted');
        } catch (ValidationException) {
            $this->assertTrue(true);
        }
        try {
            $service->save($identity, hash('sha256', 'payload'), fn () => throw new \RuntimeException);
        } catch (\RuntimeException) {
            $this->assertSame(0, DB::table('report_submissions')->count());
        }
        [$report, $created] = $service->save($identity, hash('sha256', 'payload'), fn () => Report::create(['case_number' => 'CASE-ONE']));
        [$retry, $createdAgain] = $service->save($identity, hash('sha256', 'payload'), fn () => throw new \RuntimeException('duplicate creation'));
        $this->assertTrue($created);
        $this->assertFalse($createdAgain);
        $this->assertSame($report->id, $retry->id);
    }
}
