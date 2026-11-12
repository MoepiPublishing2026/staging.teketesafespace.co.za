<?php

namespace Tests\Turnstile;

use App\Livewire\ReportForm;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TurnstileTestCase;

class SubmissionTest extends TurnstileTestCase
{
    private function form(bool $anonymous = true)
    {
        return Livewire::test(ReportForm::class, ['abuseTypeID' => 1, 'isAnonymous' => $anonymous ? 'anonymous' : 'non-anonymous'])
            ->set('subtypeID', 1)->set('reporterEmail', 'fictional@example.com')
            ->set('phoneNumber', '0821234567')->set('age', 10)->set('grade', 'Grade 4')
            ->set('location', '123 Test Street, Gauteng')->set('schoolName', 'Test School')
            ->set('schoolId', 1)->set('fullName', 'Fictional Person');
    }

    public function test_widget_is_directly_before_submit_without_duplicate_alpine(): void
    {
        $html = $this->get('/report-form/1/anonymous')->assertOk()->getContent();
        $this->assertLessThan(strpos($html, 'type="submit"'), strpos($html, 'Human verification'));
        $this->assertStringNotContainsString('unpkg.com/alpinejs', $html);
        $this->assertStringContainsString('wire:ignore', $html);
        $this->assertStringContainsString('x-data="reportTurnstile($wire, $el)"', $html);
        $this->assertStringContainsString('data-turnstile-host', $html);
        $this->assertMatchesRegularExpression('/report-turnstile\.js\?v=[a-f0-9]{12}/', $html);
        $this->assertStringNotContainsString('test-secret', $html);
    }

    public function test_missing_token_cannot_bypass_server_action(): void
    {
        Mail::fake();
        Storage::fake('attachments');
        $before = $this->permanentPublicFiles();
        $form = $this->form()->set('image', [UploadedFile::fake()->createWithContent('fictional.pdf', "%PDF-1.4\n1 0 obj<<>>endobj\ntrailer<<>>\n%%EOF\n")]);
        $form->call('submitReport')->assertHasErrors('turnstileToken')->assertDispatched('report-verification-reset')
            ->assertSet('reporterEmail', 'fictional@example.com');
        $this->assertTrue($form->get('image')[0]->exists());
        $this->assertDatabaseCount('reports', 0);
        $this->assertSame([], Storage::disk('attachments')->allFiles());
        $this->assertSame($before, $this->permanentPublicFiles());
        Http::assertNothingSent();
        Mail::assertNothingOutgoing();
    }

    public function test_honeypot_field_is_rendered_hidden_and_bound_to_the_component(): void
    {
        $html = $this->get('/report-form/1/anonymous')->assertOk()->getContent();
        $this->assertMatchesRegularExpression('/aria-hidden="true"[^>]*>\s*<label for="website">.*?<input[^>]*wire:model="website"[^>]*tabindex="-1"[^>]*autocomplete="off"/s', $html);
        $this->assertStringContainsString('left:-9999px', $html);
    }

    public function test_filled_honeypot_is_blocked_before_verification_or_any_write(): void
    {
        Mail::fake();
        Storage::fake('attachments');
        $before = $this->permanentPublicFiles();

        $form = $this->form()->set('website', 'https://spam.example')->call('submitReport');

        $form->assertHasNoErrors()->assertDispatched('report-verification-reset')->assertSet('website', '')
            ->assertSee('Something went wrong. Please try again.')
            ->assertDontSee('submitted successfully');
        $this->assertDatabaseCount('reports', 0);
        $this->assertSame([], Storage::disk('attachments')->allFiles());
        $this->assertSame($before, $this->permanentPublicFiles());
        Http::assertNothingSent();
        Mail::assertNothingOutgoing();
    }

    public function test_person_caught_by_honeypot_false_positive_can_retry_immediately(): void
    {
        Http::fake();
        $form = $this->form()->set('website', 'autofilled')->call('submitReport');
        $form->assertSet('website', '');

        // Second attempt with the honeypot now empty must reach normal processing (no token -> verification error).
        $form->call('submitReport')->assertHasErrors('turnstileToken');
    }

    private function permanentPublicFiles(): array
    {
        $path = public_path('storage');

        return is_dir($path) ? array_map(fn ($file) => $file->getPathname(), File::allFiles($path)) : [];
    }

    public static function rejectedProviderTokens(): array
    {
        return [
            'invalid token' => ['invalid-input-response'],
            // Cloudflare deliberately uses the same response for expiry and replay.
            'expired token' => ['timeout-or-duplicate'],
            'already-used token' => ['timeout-or-duplicate'],
        ];
    }

    #[DataProvider('rejectedProviderTokens')]
    public function test_rejected_tokens_cannot_write_or_send_and_preserve_uploads(string $errorCode): void
    {
        Mail::fake();
        Storage::fake('attachments');
        Http::fake(['challenges.cloudflare.com/*' => Http::response(['success' => false, 'error-codes' => [$errorCode]])]);
        $before = $this->permanentPublicFiles();
        $form = $this->form()->set('image', [UploadedFile::fake()->createWithContent('fictional.pdf', "%PDF-1.4\n1 0 obj<<>>endobj\ntrailer<<>>\n%%EOF\n")])
            ->set('turnstileToken', 'fixture-only')->call('submitReport')
            ->assertHasErrors('turnstileToken')->assertSet('turnstileToken', '')
            ->assertSet('reporterEmail', 'fictional@example.com')->assertSet('schoolId', 1)
            ->assertDispatched('report-verification-reset');
        $this->assertTrue($form->get('image')[0]->exists());
        $this->assertDatabaseCount('reports', 0);
        $this->assertSame([], Storage::disk('attachments')->allFiles());
        $this->assertSame($before, $this->permanentPublicFiles());
        Http::assertSentCount(1);
        Mail::assertNothingOutgoing();
    }

    public function test_reusing_a_previously_accepted_token_has_no_additional_side_effects(): void
    {
        Mail::fake();
        Storage::fake('attachments');
        Http::fakeSequence()->push(['success' => true, 'hostname' => 'reports.test', 'action' => 'report_submit'])
            ->push(['success' => false, 'error-codes' => ['timeout-or-duplicate']]);
        $this->form()->set('turnstileToken', 'same-fixture-token')->call('submitReport')->assertHasNoErrors();
        $this->assertDatabaseCount('reports', 1);
        Mail::assertSentCount(1);

        $before = $this->permanentPublicFiles();
        $form = $this->form()->set('image', [UploadedFile::fake()->createWithContent('retry.pdf', "%PDF-1.4\n1 0 obj<<>>endobj\ntrailer<<>>\n%%EOF\n")])
            ->set('turnstileToken', 'same-fixture-token')->call('submitReport')
            ->assertHasErrors('turnstileToken')->assertSet('reporterEmail', 'fictional@example.com')
            ->assertDispatched('report-verification-reset');
        $this->assertTrue($form->get('image')[0]->exists());
        $this->assertDatabaseCount('reports', 1);
        $this->assertSame([], Storage::disk('attachments')->allFiles());
        $this->assertSame($before, $this->permanentPublicFiles());
        Mail::assertSentCount(1);
        Mail::assertNothingQueued();
        Http::assertSentCount(2);
    }

    public static function invalidProviderMetadata(): array
    {
        return [
            'invalid' => [['success' => false, 'error-codes' => ['invalid-input-response']]],
            'expired or replayed' => [['success' => false, 'error-codes' => ['timeout-or-duplicate']]],
            'wrong hostname' => [['success' => true, 'hostname' => 'wrong.test', 'action' => 'report_submit']],
            'wrong action' => [['success' => true, 'hostname' => 'reports.test', 'action' => 'wrong']],
            'non-boolean success' => [['success' => 'true', 'hostname' => 'reports.test', 'action' => 'report_submit']],
            'missing metadata' => [[]],
        ];
    }

    #[DataProvider('invalidProviderMetadata')]
    public function test_invalid_metadata_expired_replayed_and_malformed_responses_preserve_draft_and_upload(array $result): void
    {
        Mail::fake();
        Storage::fake('attachments');
        Http::fake(['challenges.cloudflare.com/*' => Http::response($result)]);
        $form = $this->form()->set('image', [UploadedFile::fake()->createWithContent('fictional.pdf', "%PDF-1.4\n1 0 obj<<>>endobj\ntrailer<<>>\n%%EOF\n")]);
        $form->set('turnstileToken', 'not-logged')->call('submitReport')->assertHasErrors('turnstileToken')
            ->assertSet('reporterEmail', 'fictional@example.com')->assertSet('schoolId', 1)
            ->assertSet('turnstileToken', '')->assertDispatched('report-verification-reset');
        $this->assertCount(1, $form->get('image'));
        $this->assertTrue($form->get('image')[0]->exists());
        $this->assertDatabaseCount('reports', 0);
        $this->assertSame([], Storage::disk('attachments')->allFiles());
        Mail::assertNothingSent();
    }

    public function test_network_and_http_errors_fail_closed(): void
    {
        Mail::fake();
        Http::fake(fn () => throw new ConnectionException('Simulated connection error'));
        $this->form()->set('turnstileToken', 'not-logged')->call('submitReport')->assertHasErrors('turnstileToken');
        Http::swap(new \Illuminate\Http\Client\Factory);
        Http::preventStrayRequests();
        Http::fake(['*' => Http::response(['success' => true, 'hostname' => 'reports.test', 'action' => 'report_submit'], 503)]);
        $this->form()->set('turnstileToken', 'not-logged')->call('submitReport')->assertHasErrors('turnstileToken');
        $this->assertDatabaseCount('reports', 0);
        Mail::assertNothingSent();
    }

    public function test_local_hostname_mismatch_rejects_success_then_matching_configuration_allows_retry(): void
    {
        Mail::fake();
        Http::fake(['challenges.cloudflare.com/*' => Http::response([
            'success' => true, 'hostname' => '127.0.0.1', 'action' => 'report_submit',
        ])]);
        config(['turnstile.hostnames' => ['example.com']]);
        $form = $this->form()->set('turnstileToken', 'first-fixture-token')->call('submitReport')
            ->assertHasErrors('turnstileToken')->assertSet('turnstileToken', '')
            ->assertSet('reporterEmail', 'fictional@example.com')->assertSet('schoolId', 1);
        $this->assertDatabaseCount('reports', 0);
        Mail::assertNothingSent();

        config(['turnstile.hostnames' => ['127.0.0.1', 'localhost']]);
        $form->set('turnstileToken', 'fresh-fixture-token')->call('submitReport')->assertHasNoErrors();
        $this->assertDatabaseCount('reports', 1);
        Mail::assertSentCount(1);
    }

    public function test_missing_configuration_and_oversized_tokens_fail_without_http(): void
    {
        config(['turnstile.secret_key' => null]);
        $this->form()->set('turnstileToken', 'not-logged')->call('submitReport')->assertHasErrors('turnstileToken');
        config(['turnstile.secret_key' => 'test-secret']);
        $this->form()->set('turnstileToken', str_repeat('x', 2049))->call('submitReport')->assertHasErrors('turnstileToken');
        Http::assertNothingSent();
        $this->assertDatabaseCount('reports', 0);
    }

    public function test_validation_failure_resets_verification_without_losing_fields(): void
    {
        $this->form()->set('reporterEmail', 'invalid')->set('turnstileToken', 'not-logged')
            ->call('submitReport')->assertHasErrors('reporterEmail')->assertSet('turnstileToken', '')
            ->assertSet('phoneNumber', '0821234567')->assertDispatched('report-verification-reset');
        Http::assertNothingSent();
    }

    public function test_successful_anonymous_and_named_reports_are_verified_before_mail(): void
    {
        Mail::fake();
        Http::fake(['challenges.cloudflare.com/*' => Http::response(['success' => true, 'hostname' => 'reports.test', 'action' => 'report_submit'])]);
        foreach ([true, false] as $anonymous) {
            $this->form($anonymous)->set('turnstileToken', 'not-logged')->call('submitReport')
                ->assertHasNoErrors()->assertSet('turnstileToken', '')->assertDispatched('report-verification-reset');
        }
        $this->assertDatabaseCount('reports', 2);
        Http::assertSentCount(2);
        Mail::assertSentCount(2);
    }

    public function test_verification_precedes_permanent_attachment_and_report_writes(): void
    {
        Mail::fake();
        Storage::fake('attachments');
        Http::fake(function () {
            $this->assertDatabaseCount('reports', 0);
            $this->assertSame([], Storage::disk('attachments')->allFiles());
            Mail::assertNothingSent();

            return Http::response(['success' => true, 'hostname' => 'reports.test', 'action' => 'report_submit']);
        });
        $this->form()->set('image', [UploadedFile::fake()->createWithContent('fictional.pdf', "%PDF-1.4\n1 0 obj<<>>endobj\ntrailer<<>>\n%%EOF\n")])
            ->set('turnstileToken', 'not-logged')->call('submitReport')->assertHasNoErrors();
        $this->assertDatabaseCount('reports', 1);
        $this->assertCount(1, Storage::disk('attachments')->allFiles());
        Mail::assertSentCount(1);
    }
}
