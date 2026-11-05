<?php

namespace App\Console\Commands;

use App\Models\AuditLog;
use App\Services\AuditTrailService;
use Illuminate\Console\Command;

class AuditExportSigned extends Command
{
    protected $signature = 'audit:export-signed {--days=30 : Number of days of logs to export}';
    protected $description = 'Generate a cryptographically signed forensic audit export for legal compliance and external auditors';

    public function handle(AuditTrailService $auditService): int
    {
        $this->info("Initiating Forensic Audit Trail Export...");

        // 1. Verify chain integrity before exporting
        $broken = $auditService->verifyChainIntegrity();
        if (!empty($broken)) {
            $this->error("CRITICAL: Cannot export compromised ledger. Broken record IDs: " . implode(', ', $broken));
            return self::FAILURE;
        }

        $days = (int) $this->option('days');
        $since = now()->subDays($days);
        $logs = AuditLog::where('created_at', '>=', $since)->orderBy('id')->get();

        if ($logs->isEmpty()) {
            $this->warn("No audit records found in the last {$days} days.");
            return self::SUCCESS;
        }

        // 2. Prepare canonical JSON evidence payload
        $canonicalData = json_encode([
            'exported_at'      => now()->toIso8601String(),
            'platform'         => 'Tekete SafeSpace Safeguarding Platform',
            'export_scope_days'=> $days,
            'total_records'    => $logs->count(),
            'chain_head_hash'  => $logs->last()->current_hash,
            'records'          => $logs,
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        // 3. Compute Detached HMAC-SHA256 Signature using application key
        $signature = hash_hmac('sha256', $canonicalData, config('app.key'));

        // 4. Save evidence bundle to storage/app/forensic-exports
        $dir = storage_path('app/forensic-exports');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $dateStr   = now()->format('Y-m-d_His');
        $dataFile  = "{$dir}/forensic-audit-{$dateStr}.json";
        $sigFile   = "{$dir}/forensic-audit-{$dateStr}.sig";

        file_put_contents($dataFile, $canonicalData);
        file_put_contents($sigFile, $signature);

        // 5. Record the export itself into the audit trail (meta-auditing)
        $auditService->record(
            action: 'FORENSIC_EXPORT_GENERATED',
            reason: "Signed legal evidence export generated for past {$days} days",
            metadata: [
                'records_exported' => $logs->count(),
                'signature'        => $signature,
                'data_file'        => basename($dataFile)
            ]
        );

        $this->info("======================================================");
        $this->info(" FORENSIC CHAIN-OF-CUSTODY EXPORT COMPLETE");
        $this->info("======================================================");
        $this->line("Evidence Payload : {$dataFile}");
        $this->line("HMAC Signature   : {$sigFile}");
        $this->line("Signature Hash   : {$signature}");
        $this->info("======================================================");
        $this->comment("Audit entry for this export was appended to the immutable chain.");

        return self::SUCCESS;
    }
}