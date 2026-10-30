<?php

namespace Tests\Turnstile;

use App\Livewire\ReportForm;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TurnstileTestCase;

/**
 * Finding #10 (private attachments) together with the report CAPTCHA and submission limiter:
 * both must hold on the same submit.
 */
class AttachmentsTest extends TurnstileTestCase
{
    private function form()
    {
        return Livewire::test(ReportForm::class, ['abuseTypeID' => 1, 'isAnonymous' => 'anonymous'])
            ->set('subtypeID', 1)->set('reporterEmail', 'fictional@example.com')
            ->set('phoneNumber', '0821234567')->set('age', 10)->set('grade', 'Grade 4')
            ->set('location', '123 Test Street, Gauteng')->set('schoolName', 'Test School')
            ->set('schoolId', 1)->set('fullName', 'Fictional Person');
    }

    private function verified(): void
    {
        Http::fake(['challenges.cloudflare.com/*' => Http::response(['success' => true, 'hostname' => 'reports.test', 'action' => 'report_submit'])]);
    }

    private function publicFiles(): array
    {
        $path = public_path('storage');

        return is_dir($path) ? array_map(fn ($f) => $f->getPathname(), File::allFiles($path)) : [];
    }

    public function test_attachment_is_stored_privately_under_a_generated_name_and_never_on_the_public_disk(): void
    {
        Mail::fake();
        Storage::fake('attachments');
        Storage::fake('public');
        $before = $this->publicFiles();
        $this->verified();

        $this->form()->set('image', [UploadedFile::fake()->image('Screenshot 2026-10-20 162042.png', 300, 200)])
            ->set('turnstileToken', 'not-logged')->call('submitReport')->assertHasNoErrors();

        $this->assertDatabaseCount('reports', 1);
        $paths = json_decode(\DB::table('reports')->value('image_path'), true);
        $this->assertCount(1, $paths);
        $this->assertMatchesRegularExpression('#^reports/[0-9a-z]{26}\.png$#', $paths[0]);
        $this->assertTrue(Storage::disk('attachments')->exists($paths[0]));
        $this->assertSame([], Storage::disk('public')->allFiles(), 'nothing may be written to the public disk');
        $this->assertSame($before, $this->publicFiles(), 'nothing may be copied under public/storage');
    }

    public function test_file_disguised_as_an_image_is_rejected_without_saving_anything_or_burning_the_report(): void
    {
        Mail::fake();
        Storage::fake('attachments');
        $this->verified();
        $evil = UploadedFile::fake()->createWithContent('photo.png', '<?php system($_GET["c"]); ?>');

        $form = $this->form()->set('image', [$evil])->set('turnstileToken', 'not-logged')->call('submitReport');

        $form->assertHasErrors();
        $this->assertDatabaseCount('reports', 0);
        $this->assertSame([], Storage::disk('attachments')->allFiles());
        Mail::assertNothingSent();
    }

    public function test_too_many_attachments_are_refused(): void
    {
        Mail::fake();
        Storage::fake('attachments');
        $this->verified();
        $files = array_map(fn ($i) => UploadedFile::fake()->image("p$i.png"), range(1, 6));   // limit is 5

        $this->form()->set('image', $files)->set('turnstileToken', 'not-logged')->call('submitReport')->assertHasErrors('image');

        $this->assertDatabaseCount('reports', 0);
        $this->assertSame([], Storage::disk('attachments')->allFiles());
    }

    public function test_a_mail_outage_after_saving_does_not_report_a_failed_submission(): void
    {
        Storage::fake('attachments');
        $this->verified();
        config(['mail.default' => 'smtp', 'mail.mailers.smtp.host' => '127.0.0.1', 'mail.mailers.smtp.port' => 1, 'mail.mailers.smtp.timeout' => 1]);
        app()->forgetInstance('mail.manager');

        $html = $this->form()->set('turnstileToken', 'not-logged')->call('submitReport')->html();

        $this->assertDatabaseCount('reports', 1);
        $this->assertStringNotContainsString('Something went wrong', $html);
        $this->assertStringContainsString('CASE-', $html);
        $this->assertStringContainsString('could not email your case number', $html);
    }
}
