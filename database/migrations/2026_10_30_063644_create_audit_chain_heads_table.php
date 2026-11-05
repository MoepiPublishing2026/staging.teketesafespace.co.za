<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_chain_heads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('row_count');
            $table->unsignedBigInteger('max_id');
            $table->string('chain_head_hash', 64);
            $table->timestamp('recorded_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_chain_heads');
    }
};