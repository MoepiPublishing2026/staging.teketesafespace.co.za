<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class SafeguardingIdentityVault
{
    public function __construct(private AuditTrailService $auditTrail) {}

    /**
     * Encrypts sensitive reporter metadata (AES-256) and generates an irreversible
     * HMAC-SHA256 blind index of the IP for rate-limiting/correlation without plaintext exposure.
     */
    public function sealIdentity(array $sensitivePayload, ?string $ipAddress = null): array
    {
        $ip = $ipAddress ?? request()->ip() ?? '0.0.0.0';

        // HMAC-SHA256 Blind Index: searchable for abuse correlation, impossible to reverse into an IP
        $ipBlindIndex = hash_hmac('sha256', $ip, (string) config('app.key'));

        $envelope = [
            'ip_address' => $ip,
            'sealed_at'  => now()->toIso8601String(),
            'data'       => $sensitivePayload,
        ];

        return [
            'encrypted_identity_blob' => Crypt::encryptString(json_encode($envelope)),
            'ip_blind_index'          => $ipBlindIndex,
        ];
    }

    /**
     * "Break-Glass" Emergency Unmasking:
     * Enforces mandatory justification and writes an immutable SHA-256 chained audit log
     * BEFORE decrypting learner safeguarding information (Fail-Closed Design).
     */
    public function unmaskForEmergency(
        string $encryptedBlob,
        string $emergencyReason,
        ?object $subject = null,
        ?string $actorId = null,
        ?string $actorRole = null
    ): array {
        $cleanReason = trim($emergencyReason);

        if (strlen($cleanReason) < 15) {
            throw new InvalidArgumentException(
                'Break-glass emergency unmasking requires a detailed safeguarding justification (minimum 15 characters).'
            );
        }

        // Fail-Closed: Record the unmasking in the immutable SHA-256 audit trail FIRST
        return DB::transaction(function () use ($encryptedBlob, $cleanReason, $subject, $actorId, $actorRole) {
            $auditEntry = $this->auditTrail->record(
                action: 'VIEWED_SENSITIVE_INFORMATION',
                reason: $cleanReason,
                subject: $subject,
                metadata: ['access_type' => 'BREAK_GLASS_EMERGENCY_UNMASK'],
                actorId: $actorId,
                actorRole: $actorRole
            );

            Log::channel('security')->alert('BREAK_GLASS_IDENTITY_UNMASKED', [
                'audit_log_id' => $auditEntry->id,
                'actor_id'     => $auditEntry->actor_id,
                'actor_role'   => $auditEntry->actor_role,
                'reason'       => $cleanReason,
                'chain_hash'   => $auditEntry->current_hash,
            ]);

            $decryptedJson = Crypt::decryptString($encryptedBlob);

            return json_decode($decryptedJson, true);
        });
    }
}