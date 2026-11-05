<?php

namespace App\Console\Commands;

use App\Models\AuditLog;
use App\Notifications\SecurityAlertNotification;
use App\Services\AuditCheckpointService;
use App\Services\AuditTrailService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SecurityAnomalyCheck extends Command
{
    protected $signature = 'security:check-anomalies';
    protected $description = 'Scan recent audit logs for failed logins, traffic spikes, enumeration, and chain tampering';

    private const FAILED_LOGIN_THRESHOLD = 5;
    private const SUBMISSION_SPIKE_THRESHOLD = 30;
    private const INVALID_LOOKUP_THRESHOLD = 10;
    private const BOT_BLOCK_THRESHOLD = 5;
    private const WINDOW_MINUTES = 15;

    public function handle(AuditTrailService $auditService, AuditCheckpointService $checkpointService): int
    {
        $since = now()->subMinutes(self::WINDOW_MINUTES);
        $alerts = [];

        // 1. Failed login spikes per IP
        $failedLogins = AuditLog::where('action', 'LOGIN_FAILED')
            ->where('created_at', '>=', $since)
            ->selectRaw('ip_address, COUNT(*) as attempts')
            ->groupBy('ip_address')
            ->having('attempts', '>=', self::FAILED_LOGIN_THRESHOLD)
            ->get();

        foreach ($failedLogins as $row) {
            $alerts[] = "⚠️ Brute-force alert: {$row->attempts} failed login attempts from IP {$row->ip_address} in the last " . self::WINDOW_MINUTES . " minutes.";
        }

        // 2. Report submission spikes
        $submissionCount = AuditLog::where('action', 'REPORT_SUBMITTED')
            ->where('created_at', '>=', $since)
            ->count();

        if ($submissionCount >= self::SUBMISSION_SPIKE_THRESHOLD) {
            $alerts[] = "⚠️ Traffic spike alert: {$submissionCount} reports submitted in the last " . self::WINDOW_MINUTES . " minutes.";
        }

        // 3. Suspicious case-status lookups (enumeration)
        $invalidLookups = AuditLog::where('action', 'CHECKED_STATUS')
            ->where('reason', 'Invalid/unknown reference attempted')
            ->where('created_at', '>=', $since)
            ->selectRaw('ip_address, COUNT(*) as attempts')
            ->groupBy('ip_address')
            ->having('attempts', '>=', self::INVALID_LOOKUP_THRESHOLD)
            ->get();

        foreach ($invalidLookups as $row) {
            $alerts[] = "⚠️ Enumeration alert: {$row->attempts} invalid case-status lookups from IP {$row->ip_address} in the last " . self::WINDOW_MINUTES . " minutes.";
        }

        // 4. Honeypot bot blocks
        $botBlocks = AuditLog::where('action', 'BOT_SUBMISSION_BLOCKED')
            ->where('created_at', '>=', $since)
            ->count();

        if ($botBlocks >= self::BOT_BLOCK_THRESHOLD) {
            $alerts[] = "⚠️ Bot activity alert: {$botBlocks} automated report submissions blocked by honeypot in the last " . self::WINDOW_MINUTES . " minutes.";
        }

        // 5. Chain integrity & tail-deletion check
        $broken = $auditService->verifyChainIntegrity();
        if (!empty($broken)) {
            $ids = array_map(fn ($item) => is_array($item) ? $item['id'] : $item, $broken);
            $alerts[] = "🚨 CRITICAL: Audit log hash chain tampering detected at entry ID(s): " . implode(', ', $ids);
        }

        $shrinkage = $checkpointService->detectShrinkage();
        foreach ($shrinkage as $issue) {
            $alerts[] = "🚨 CRITICAL: Audit log deletion detected — {$issue}";
        }

        if (empty($alerts)) {
            $this->info('✅ No security anomalies detected.');
            return self::SUCCESS;
        }

        foreach ($alerts as $alert) {
            $this->warn($alert);
            Log::channel('security')->warning('ANOMALY_ALERT', ['alert' => $alert]);
        }

        $this->notifySecurityTeam($alerts);

        return self::FAILURE;
    }

    private function notifySecurityTeam(array $alerts): void
    {
        $recipients = config('security.alert_recipients', []);

        if (empty($recipients)) {
            $this->warn('No alert recipients configured — set SECURITY_ALERT_EMAILS in .env');
            return;
        }

        Notification::route('mail', $recipients)
            ->notify(new SecurityAlertNotification($alerts));

        $this->info('📧 Security alert notification dispatched to: ' . implode(', ', $recipients));
    }
}