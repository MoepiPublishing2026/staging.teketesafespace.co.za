<?php

namespace Tests\Turnstile;

use App\Livewire\CheckStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TurnstileTestCase;

class CheckStatusTest extends TurnstileTestCase
{
    private function report(): void
    {
        DB::table('reports')->insert([
            'case_number' => 'BU-0101-0001', 'status' => 'under-review', 'abuse_type_id' => 1,
            'subtype_id' => 1, 'description' => 'Fictional description', 'school_name' => 'Test School',
            'is_anonymous' => true, 'created_at' => now(), 'updated_at' => now(),
        ]);
    }

    private function verified(string $action = 'check_status'): void
    {
        Http::fake(['challenges.cloudflare.com/*' => Http::response([
            'success' => true, 'hostname' => 'reports.test', 'action' => $action,
        ])]);
    }

    public function test_widget_is_before_search_button_with_check_status_action_and_no_duplicate_alpine(): void
    {
        $html = $this->get('/check-status')->assertOk()->getContent();
        $this->assertLessThan(strpos($html, 'type="submit"'), strpos($html, 'Human verification'));
        $this->assertStringContainsString('data-action="check_status"', $html);
        $this->assertStringContainsString('x-data="reportTurnstile($wire, $el)"', $html);
        $this->assertMatchesRegularExpression('/report-turnstile\.js\?v=[a-f0-9]{12}/', $html);
        $this->assertStringNotContainsString('unpkg.com/alpinejs', $html);
        $this->assertStringNotContainsString('test-secret', $html);
    }

    public function test_missing_token_returns_nothing_and_calls_no_provider(): void
    {
        $this->report();
        Livewire::test(CheckStatus::class)->set('caseNumber', 'BU-0101-0001')->call('checkStatus')
            ->assertHasErrors('turnstileToken')->assertSet('reportData', []);
        Http::assertNothingSent();
    }

    public function test_rejected_token_returns_nothing_and_resets_widget(): void
    {
        $this->report();
        Http::fake(['challenges.cloudflare.com/*' => Http::response(['success' => false, 'error-codes' => ['timeout-or-duplicate']])]);
        Livewire::test(CheckStatus::class)->set('caseNumber', 'BU-0101-0001')->set('turnstileToken', 'fixture-only')
            ->call('checkStatus')->assertHasErrors('turnstileToken')->assertSet('reportData', [])
            ->assertSet('turnstileToken', '')->assertDispatched('report-verification-reset');
        Http::assertSentCount(1);
    }

    public function test_token_issued_for_another_action_is_rejected(): void
    {
        $this->report();
        $this->verified('report_submit');
        Livewire::test(CheckStatus::class)->set('caseNumber', 'BU-0101-0001')->set('turnstileToken', 'fixture-only')
            ->call('checkStatus')->assertHasErrors('turnstileToken')->assertSet('reportData', []);
    }

    public function test_missing_configuration_fails_closed(): void
    {
        $this->report();
        config(['turnstile.hostnames' => []]);
        Livewire::test(CheckStatus::class)->set('caseNumber', 'BU-0101-0001')->set('turnstileToken', 'fixture-only')
            ->call('checkStatus')->assertHasErrors('turnstileToken')->assertSet('reportData', []);
        Http::assertNothingSent();
    }

    public function test_valid_token_shows_status_and_token_cannot_be_reused(): void
    {
        $this->report();
        $this->verified();
        Livewire::test(CheckStatus::class)->set('caseNumber', 'bu-0101-0001')->set('turnstileToken', 'fixture-only')
            ->call('checkStatus')->assertHasNoErrors()->assertSet('reportData.case_number', 'BU-0101-0001')
            ->assertSet('reportData.status', 'under-review')->assertSet('turnstileToken', '')
            ->assertDispatched('report-verification-reset');
        Http::assertSentCount(1);
    }

    public function test_unknown_case_number_still_requires_verification(): void
    {
        $this->verified();
        Livewire::test(CheckStatus::class)->set('caseNumber', 'NOPE-0000')->set('turnstileToken', 'fixture-only')
            ->call('checkStatus')->assertHasErrors('caseNumber')->assertSet('reportData', []);
    }

    public function test_case_number_in_the_url_is_prefilled_but_never_searched_on_load(): void
    {
        $this->report();
        Livewire::withQueryParams(['caseNumber' => 'bu-0101-0001'])->test(CheckStatus::class)
            ->assertSet('caseNumber', 'BU-0101-0001')->assertSet('reportData', []);
        Http::assertNothingSent();
    }
}
