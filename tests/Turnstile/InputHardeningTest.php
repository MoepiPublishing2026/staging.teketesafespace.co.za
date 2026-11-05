<?php

namespace Tests\Turnstile;

use App\Livewire\CheckStatus;
use App\Livewire\ReportForm;
use App\Models\Report;
use App\Support\InputRules;
use Illuminate\Http\Request;
use Illuminate\Mail\Markdown;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TurnstileTestCase;

/**
 * (injection & XSS): server-side validation, output encoding in emails,
 * security headers / CSP, the CSP report collector and the static lint.
 */
class InputHardeningTest extends TurnstileTestCase
{
    private function form()
    {
        return Livewire::test(ReportForm::class, ['abuseTypeID' => 1, 'isAnonymous' => 'anonymous'])
            ->set('subtypeID', 1)->set('reporterEmail', 'fictional@example.com')
            ->set('phoneNumber', '0821234567')->set('age', 10)->set('grade', 'Grade 4')
            ->set('location', '123 Test Street, Gauteng')->set('schoolName', 'Test School')
            ->set('schoolId', 1)->set('fullName', 'Fictional Person');
    }

    /** The submission limiter deliberately counts invalid attempts, so start each attempt with a clean slate. */
    private function resetLimiter(): void
    {
        \DB::table('cache')->delete();
    }

    private function verified(): void
    {
        Http::fake(['challenges.cloudflare.com/*' => Http::response(['success' => true, 'hostname' => 'reports.test', 'action' => 'report_submit'])]);
    }

    // validation

    public function test_grade_is_an_allow_list_not_free_text(): void
    {
        Mail::fake();
        Storage::fake('attachments');
        $this->verified();

        foreach (["');alert(1);//", '<script>alert(1)</script>', 'Grade 13', str_repeat('G', 100)] as $payload) {
            $this->resetLimiter();
            $this->form()->set('grade', $payload)->set('turnstileToken', 'not-logged')->call('submitReport')->assertHasErrors('grade');
        }
        $this->assertDatabaseCount('reports', 0);
        Mail::assertNothingSent();

        $this->resetLimiter();
        $this->form()->set('grade', 'Grade 4')->set('turnstileToken', 'not-logged')->call('submitReport')->assertHasNoErrors('grade');
        $this->assertDatabaseCount('reports', 1);
    }

    public function test_age_must_be_a_whole_number_in_range(): void
    {
        $this->verified();
        foreach (['7.5', '1e1', 'abc', -1, 116] as $age) {
            $this->resetLimiter();
            $this->form()->set('age', $age)->set('turnstileToken', 'not-logged')->call('submitReport')->assertHasErrors('age');
        }
        $this->assertDatabaseCount('reports', 0);
    }

    public function test_status_lookup_rejects_malformed_case_numbers_before_touching_the_database(): void
    {
        foreach (["x' OR '1'='1", '<script>', 'AB', str_repeat('A', 41), "CASE-1\n"] as $bad) {
            Livewire::test(CheckStatus::class)->set('caseNumber', $bad)->call('checkStatus')->assertHasErrors('caseNumber');
        }
    }

    public function test_input_rules_helper_edge_cases(): void
    {
        $v = fn (array $rules, $value) => validator(['f' => $value], ['f' => $rules]);

        $this->assertTrue($v(InputRules::grade(), 'Grade R')->passes());
        $this->assertTrue($v(InputRules::grade(), 'Creche')->passes());
        $this->assertTrue($v(InputRules::grade(), 'grade 5')->fails());
        $this->assertSame(0, preg_match(InputRules::SAFE_EMAIL_REGEX, '"a\'b"@x.com'));
        $this->assertSame(0, preg_match(InputRules::SAFE_EMAIL_REGEX, "a@x.com\n"));
        $this->assertSame(1, preg_match(InputRules::SAFE_EMAIL_REGEX, 'john.doe+tag@school.co.za'));
    }

    public function test_admin_list_filters_drop_bad_values_and_keep_good_ones(): void
    {
        $request = Request::create('/x', 'GET', [
            'search' => str_repeat('x', 500), 'status' => '<script>', 'date_from' => '2026-13-45',
            'case_number' => "' OR 1=1 --", 'full_name' => 'Jane Doe', 'filter_status' => 'closed', 'date_to' => '2026-02-01',
        ]);
        InputRules::sanitizeReportFilters($request);

        foreach (['search', 'status', 'date_from', 'case_number'] as $dropped) {
            $this->assertFalse($request->query->has($dropped), "$dropped should be dropped");
        }
        $this->assertSame('Jane Doe', $request->query('full_name'));
        $this->assertSame('closed', $request->query('filter_status'));
        $this->assertSame('2026-02-01', $request->query('date_to'));
    }

    // output encoding (emails)

    public function test_reporter_text_cannot_inject_links_or_images_into_admin_emails(): void
    {
        $attack = '[Reset password](https://evil.example/login) ![t](https://tracker.example/p.png) <img src=x onerror=alert(1)> https://phish.example/x';
        $report = new Report();
        foreach (['case_number' => 'CASE-AB1', 'location' => $attack, 'full_name' => $attack, 'reporter_email' => 'a@b.co',
                  'phone_number' => '0123456789', 'reporter_clarification' => $attack, 'status' => 'closed', 'is_anonymous' => false] as $k => $v) {
            $report->{$k} = $v;
        }
        $markdown = new Markdown(view(), ['theme' => 'default', 'paths' => []]);

        foreach (['incident-reported' => ['report' => $report, 'timestamp' => 'now'], 'report_updated' => ['report' => $report, 'timestamp' => 'now'],
                  'admin_report_clarification' => ['report' => $report]] as $template => $data) {
            $html = (string) $markdown->render("emails.$template", $data);
            preg_match_all('/(?:href|src)="([^"]+)"/', $html, $m);
            foreach ($m[1] as $ref) {
                $this->assertDoesNotMatchRegularExpression('/evil\.example|tracker\.example|phish\.example/', $ref, "emails.$template carries an attacker reference");
            }
            $this->assertDoesNotMatchRegularExpression('/<img[^>]*onerror/i', $html, "emails.$template renders injected HTML");
        }
    }

    // headers / CSP

    public function test_every_response_carries_the_security_headers_and_hides_php(): void
    {
        $response = $this->get('/up');

        $csp = $response->headers->get('Content-Security-Policy');
        $this->assertStringContainsString("object-src 'none'", $csp);
        $this->assertStringContainsString("frame-ancestors 'self'", $csp);
        $this->assertStringContainsString('https://www.payfast.co.za', $csp);          // payment redirect keeps working
        $this->assertStringContainsString('script-src', (string) $response->headers->get('Content-Security-Policy-Report-Only'));
        $this->assertStringContainsString('challenges.cloudflare.com', (string) $response->headers->get('Content-Security-Policy-Report-Only'));  // Turnstile
        $this->assertSame('nosniff', $response->headers->get('X-Content-Type-Options'));
        $this->assertSame('SAMEORIGIN', $response->headers->get('X-Frame-Options'));
        $this->assertFalse($response->headers->has('X-Powered-By'));

        $this->get('/definitely-not-a-page')->assertNotFound()->assertHeader('X-Content-Type-Options', 'nosniff');
    }

    public function test_enforce_mode_merges_the_resource_policy_into_one_enforced_header(): void
    {
        config(['tekete.csp_mode' => 'enforce']);
        $response = $this->get('/up');

        $this->assertStringContainsString('script-src', $response->headers->get('Content-Security-Policy'));
        $this->assertStringContainsString("object-src 'none'", $response->headers->get('Content-Security-Policy'));
        $this->assertFalse($response->headers->has('Content-Security-Policy-Report-Only'));
    }

    public function test_api_does_not_send_a_wildcard_cors_header(): void
    {
        $response = $this->get('/api/schools', ['Origin' => 'https://evil.example']);

        $this->assertFalse($response->headers->has('Access-Control-Allow-Origin'));
    }

    public function test_csp_report_endpoint_accepts_reports_strips_queries_and_caps_size(): void
    {
        $report = json_encode(['csp-report' => ['document-uri' => 'https://s.example/check-status?caseNumber=SECRET1', 'blocked-uri' => 'https://evil.example/x.js?token=abc', 'effective-directive' => 'script-src-elem']]);

        $this->call('POST', '/csp-report', [], [], [], ['CONTENT_TYPE' => 'application/csp-report'], $report)->assertNoContent();
        $this->call('POST', '/csp-report', [], [], [], ['CONTENT_TYPE' => 'application/csp-report'], 'not json')->assertNoContent();
        $this->call('POST', '/csp-report', [], [], [], ['CONTENT_TYPE' => 'application/csp-report'], str_repeat('A', 9000))->assertStatus(413);
    }

    // static lint

    public function test_static_security_lint_is_clean(): void
    {
        exec('php ' . escapeshellarg(base_path('scripts/security-lint.php')) . ' 2>&1', $output, $code);

        $this->assertSame(0, $code, implode("\n", $output));
    }
}
