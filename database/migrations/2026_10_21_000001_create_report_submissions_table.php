<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('report_submissions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('session_hash', 64);
            $table->char('payload_hash', 64);
            $table->unsignedBigInteger('report_id')->nullable()->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_submissions');
    }
};
