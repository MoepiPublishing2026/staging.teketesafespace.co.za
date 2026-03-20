<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if the 'reports' table exists before attempting to modify it
        if (Schema::hasTable('reports')) {
            Schema::table('reports', function (Blueprint $table) {
                // Add a new column to store the reason for the latest status change.
                // It is nullable initially, as existing reports won't have a reason.
                $table->text('latest_status_reason')
                    ->after('status') // Place it right after the status column for logical grouping
                    ->nullable()
                    ->comment('Reason provided by admin for the latest status update.');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Check if the 'reports' table exists and the column exists before dropping it
        if (Schema::hasTable('reports') && Schema::hasColumn('reports', 'latest_status_reason')) {
            Schema::table('reports', function (Blueprint $table) {
                $table->dropColumn('latest_status_reason');
            });
        }
    }
};
