<?php

namespace App\Console\Commands;

use App\Models\AuditLog;
use App\Services\AuditCheckpointService;
use App\Services\AuditTrailService;
use Illuminate\Console\Command;

class SecurityWeeklySummary extends Command
{
    protected $signature = 'security:weekly-summary';
    protected $description = 'Generate security event metrics for the weekly IT Support report';

    public function handle(AuditTrailService $auditService, AuditCheckpointService $checkpointService): int
    {
        $since = now()->subDays(7);

        $metrics = [
            'Failed Admin Logins'      => AuditLog::where('action', 'LOGIN_FAILED')->where('created_at', '>=', $since)->count(),
            'Total Reports Submitted'  => AuditLog::where('action', 'REPORT_SUBMITTED')->where('created_at', '>=', $since)->count(),
            'Case Status Lookups'      => AuditLog::where('action', 'CHECKED_STATUS')->where('created_at', '>=', $since)->count(),
            'Blocked Honeypot Bots'    => AuditLog::where('action', 'BOT_SUBMISSION_BLOCKED')->where('created_at', '>=', $since)->count(),
            'HTTP 5xx Server Errors'   => AuditLog::where('action', 'HTTP_SERVER_ERROR')->where('created_at', '>=', $since)->count(),
        ];

        $broken    = $auditService->verifyChainIntegrity();
        $shrinkage = $checkpointService->detectShrinkage();
        $chainOk   = empty($broken) && empty($shrinkage);

        $chainText = $chainOk
            ? 'VALID (No tampering or deletion)'
            : 'COMPROMISED (' . implode(', ', array_merge(
                !empty($broken) ? ['Tampered IDs: ' . implode(',', array_map(fn($i) => is_array($i) ? $i['id'] : $i, $broken))] : [],
                $shrinkage
            )) . ')';

        $statusLine = sprintf(
            "Security Events (%s to %s): FailedLogins=%d | Reports=%d | Lookups=%d | BotsBlocked=%d | 5xxErrors=%d | AuditChain=%s",
            $since->toDateString(),
            now()->toDateString(),
            $metrics['Failed Admin Logins'],
            $metrics['Total Reports Submitted'],
            $metrics['Case Status Lookups'],
            $metrics['Blocked Honeypot Bots'],
            $metrics['HTTP 5xx Server Errors'],
            $chainOk ? 'VALID' : 'COMPROMISED'
        );

        $this->info("==========================================");
        $this->info(" TEKETE SAFESPACE - WEEKLY SECURITY REPORT");
        $this->info(" Period: " . $since->toDateString() . " to " . now()->toDateString());
        $this->info("==========================================");

        $lines = [];
        foreach ($metrics as $name => $count) {
            $line = sprintf("%-28s : %d", $name, $count);
            $this->line($line);
            $lines[] = $line;
        }

        $this->line("------------------------------------------");
        if ($chainOk) {
            $this->info("Audit Trail Chain Integrity : " . $chainText);
        } else {
            $this->error("Audit Trail Chain Integrity : " . $chainText);
        }
        $this->line("------------------------------------------");
        $this->line("Weekly IT Report Line:");
        $this->line($statusLine);
        $this->info("==========================================");

        // Save to storage/app/security-reports for IT Support record-keeping
        $dir = storage_path('app/security-reports');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $file = $dir . '/weekly-security-summary-' . now()->toDateString() . '.txt';
        file_put_contents($file, implode(PHP_EOL, array_merge([
            "==========================================",
            " TEKETE SAFESPACE - WEEKLY SECURITY REPORT",
            " Period: " . $since->toDateString() . " to " . now()->toDateString(),
            "==========================================",
        ], $lines, [
            "------------------------------------------",
            "Audit Trail Chain Integrity : " . $chainText,
            "Weekly IT Report Line       : " . $statusLine,
            "==========================================",
        ])) . PHP_EOL);

        return self::SUCCESS;
    }
}