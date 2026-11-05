<?php


namespace App\Console\Commands;

use App\Services\AuditTrailService;
use Illuminate\Console\Command;

class VerifyAuditChain extends Command
{
    protected $signature = 'audit:verify';
    protected $description = 'Verify the audit log hash chain has not been tampered with';

    public function handle(AuditTrailService $service): int
{
    $broken = $service->verifyChainIntegrity();

    if (empty($broken)) {
        $this->info('✅ Audit chain integrity verified. No tampering detected.');
        return self::SUCCESS;
    }

    $this->error('🚨 TAMPERING DETECTED:');
    foreach ($broken as $issue) {
        $this->error("  Entry #{$issue['id']} — {$issue['type']}: {$issue['detail']}");
    }

    return self::FAILURE;
}
}