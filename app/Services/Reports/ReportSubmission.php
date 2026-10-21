<?php

namespace App\Services\Reports;

use App\Models\Report;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ReportSubmission
{
    public function identity(string $sessionId): string
    {
        return Crypt::encryptString(json_encode([
            'id' => (string) Str::uuid(), 'session' => $this->sessionHash($sessionId),
        ], JSON_THROW_ON_ERROR));
    }

    public function decode(string $identity, string $sessionId): array
    {
        try {
            $value = json_decode(Crypt::decryptString($identity), true, flags: JSON_THROW_ON_ERROR);
            if (! Str::isUuid($value['id'] ?? '')
                || ! hash_equals($this->sessionHash($sessionId), $value['session'] ?? '')) {
                throw new \RuntimeException;
            }

            return $value;
        } catch (\Throwable) {
            throw ValidationException::withMessages(['reportSubmission' => 'This submission belongs to another session or is invalid. Reload the form to start again.']);
        }
    }

    public function completed(array $identity): ?Report
    {
        $row = DB::table('report_submissions')->where('id', $identity['id'])
            ->where('session_hash', $identity['session'])->first();

        return $row?->report_id ? Report::findOrFail($row->report_id) : null;
    }

    public function save(array $identity, string $fingerprint, \Closure $create): array
    {
        return DB::transaction(function () use ($identity, $fingerprint, $create) {
            // Unique primary key and row lock serialize duplicates, including workers
            // with different valid CAPTCHA tokens. A crash rolls back claim + report.
            // A no-op upsert takes an exclusive duplicate-key lock on MySQL.
            // INSERT IGNORE followed by a locking read can deadlock when several
            // duplicate readers try to upgrade shared locks concurrently.
            DB::table('report_submissions')->upsert([
                'id' => $identity['id'], 'session_hash' => $identity['session'],
                'payload_hash' => $fingerprint, 'created_at' => now(), 'updated_at' => now(),
            ], ['id'], ['id']);
            $row = DB::table('report_submissions')->where('id', $identity['id'])->lockForUpdate()->first();
            if (! hash_equals($row->session_hash, $identity['session'])) {
                throw ValidationException::withMessages(['reportSubmission' => 'Invalid submission session.']);
            }
            if ($row->report_id) {
                return [Report::findOrFail($row->report_id), false];
            }
            if (! hash_equals($row->payload_hash, $fingerprint)) {
                throw ValidationException::withMessages(['reportSubmission' => 'The submission contents have changed. Please start a new report.']);
            }
            $report = $create();
            DB::table('report_submissions')->where('id', $identity['id'])->update([
                'report_id' => $report->id, 'updated_at' => now(),
            ]);

            return [$report, true];
        });
    }

    private function sessionHash(string $sessionId): string
    {
        return hash_hmac('sha256', 'report-session:'.$sessionId, config('app.key'));
    }
}
