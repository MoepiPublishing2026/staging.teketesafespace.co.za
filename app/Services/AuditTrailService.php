<?php
// app/Services/AuditTrailService.php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuditTrailService
{
    private const GENESIS_HASH =
    '0000000000000000000000000000000000000000000000000000000000000000';

    public function record(
        string $action,
        ?string $reason = null,
        ?object $subject = null,
        ?array $metadata = null,
        ?string $actorId = null,
        ?string $actorRole = null
    ): AuditLog {
        return DB::transaction(function () use ($action, $reason, $subject, $metadata, $actorId, $actorRole) {

            $previous = AuditLog::query()
                ->orderByDesc('id')
                ->lockForUpdate()
                ->first();

            $previousHash = $previous?->current_hash ?? self::GENESIS_HASH;

            $payload = [
                'previous_hash' => $previousHash,
                'actor_id'      => $actorId ?? (Auth::check() ? (string) Auth::id() : null),
                'actor_role'    => $actorRole ?? (Auth::check() ? Auth::user()->role : null),
                'action'        => $action,
                'reason'        => $reason,
                'subject_type'  => $subject ? get_class($subject) : null,
                'subject_id'    => $subject->id ?? null,
                'metadata'      => $metadata,
                'ip_address'    => request()->ip(),
                'created_at'    => now()->toDateTimeString(),
            ];

            $currentHash = $this->computeHash($payload);

            return AuditLog::create([
                ...$payload,
                'current_hash' => $currentHash,
            ]);
        });

        $log = AuditLog::create([
            ...$payload,
            'current_hash' => $currentHash,
        ]);

        Log::channel('security')->info($action, [
            'actor_id'   => $payload['actor_id'],
            'actor_role' => $payload['actor_role'],
            'reason'     => $payload['reason'],
            'ip'         => $payload['ip_address'],
            'hash'       => $currentHash,
        ]);

        return $log;
    }

    private function computeHash(array $payload): string
    {
        $canonical = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        return hash('sha256', $canonical);
    }

    public function verifyChainIntegrity(): array
    {
        $previousHash = self::GENESIS_HASH;
        $broken = [];

        AuditLog::orderBy('id')->chunk(500, function ($logs) use (&$previousHash, &$broken) {
            foreach ($logs as $log) {
                $payload = [
                    'previous_hash' => $previousHash,
                    'actor_id'      => $log->actor_id,
                    'actor_role'    => $log->actor_role,
                    'action'        => $log->action,
                    'reason'        => $log->reason,
                    'subject_type'  => $log->subject_type,
                    'subject_id'    => $log->subject_id,
                    'metadata'      => $log->metadata,
                    'ip_address'    => $log->ip_address,
                    'created_at'    => $log->created_at->toDateTimeString(),
                ];

                $expected = $this->computeHash($payload);

                // Check 1: Verify the link to the previous event.
                $linkValid = hash_equals(
                    $previousHash,
                    $log->previous_hash
                );

                // Check 2: Verify that event content has not changed.
                $contentValid = hash_equals(
                    $expected,
                    $log->current_hash
                );

                if (!$linkValid || !$contentValid) {
                    $broken[] = $log->id;
                }

                $previousHash = $log->current_hash;
            }
        });

        return $broken;
    }
}
