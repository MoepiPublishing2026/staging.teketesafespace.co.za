<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    public $timestamps = false; // we control created_at manually

    protected $fillable = [
        'subject_type', 'subject_id', 'actor_id', 'actor_role',
        'action', 'reason', 'metadata', 'ip_address',
        'previous_hash', 'current_hash', 'created_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'created_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::updating(function () {
            throw new \RuntimeException('Audit logs are immutable and cannot be updated.');
        });

        static::deleting(function () {
            throw new \RuntimeException('Audit logs are immutable and cannot be deleted.');
        });
    }
}