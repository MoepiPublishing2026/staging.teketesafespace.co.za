<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuditCheckpointService
{
    /**
     * Record a snapshot of the chain's current length and head hash
     * to both the audit_chain_heads table and an append-only log file.
     */
    public function createCheckpoint(): array
    {
        $latest = AuditLog::orderByDesc('id')->first();

        $checkpoint = [
            'timestamp'       => now()->toIso8601String(),
            'row_count'       => AuditLog::count(),
            'max_id'          => $latest->id ?? 0,
            'chain_head_hash' => $latest->current_hash ?? 'GENESIS',
        ];

        DB::table('audit_chain_heads')->insert([
            'row_count'       => $checkpoint['row_count'],
            'max_id'          => $checkpoint['max_id'],
            'chain_head_hash' => $checkpoint['chain_head_hash'],
            'recorded_at'     => now(),
        ]);

        Log::channel('checkpoint')->info('CHECKPOINT', $checkpoint);

        return $checkpoint;
    }

    /**
     * Compare current audit_logs state against a given or latest stored checkpoint.
     */
    public function detectShrinkage(?array $lastCheckpoint = null): array
    {
        if ($lastCheckpoint === null) {
            $stored = DB::table('audit_chain_heads')->orderByDesc('id')->first();
            if (!$stored) {
                return [];
            }
            $lastCheckpoint = [
                'row_count'       => $stored->row_count,
                'max_id'          => $stored->max_id,
                'chain_head_hash' => $stored->chain_head_hash,
            ];
        }

        $issues = [];
        $currentCount = AuditLog::count();
        $currentMaxId = AuditLog::max('id') ?? 0;
        $latestRow    = AuditLog::orderByDesc('id')->first();

        if ($currentCount < $lastCheckpoint['row_count']) {
            $issues[] = "Row count dropped from {$lastCheckpoint['row_count']} to {$currentCount} — entries may have been deleted.";
        }

        if ($currentMaxId < $lastCheckpoint['max_id']) {
            $issues[] = "Highest entry ID dropped from {$lastCheckpoint['max_id']} to {$currentMaxId} — the most recent entries may have been deleted.";
        }

        if (
            $currentCount === (int) $lastCheckpoint['row_count'] &&
            $latestRow &&
            $lastCheckpoint['chain_head_hash'] !== 'GENESIS' &&
            !hash_equals($lastCheckpoint['chain_head_hash'], $latestRow->current_hash)
        ) {
            $issues[] = "Chain head hash mismatch against last checkpoint — latest entry was modified or replaced.";
        }

        return $issues;
    }
}