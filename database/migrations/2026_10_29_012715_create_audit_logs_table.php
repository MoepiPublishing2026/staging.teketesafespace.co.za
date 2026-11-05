<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('subject_type')->nullable();   // e.g. App\Models\Report
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->string('actor_id')->nullable();        // null = anonymous/system
            $table->string('actor_role')->nullable();
            $table->string('action');                      // VIEWED, ESCALATED, LOGIN_FAILED, etc.
            $table->text('reason')->nullable();
            $table->json('metadata')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->string('previous_hash', 64);
            $table->string('current_hash', 64)->unique();
            $table->timestamp('created_at')->useCurrent();

            // Performance indexes for anomaly detection queries
            $table->index(['action', 'created_at']);
            $table->index('ip_address');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};