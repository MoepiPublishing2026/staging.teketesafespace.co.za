<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingFieldsToReportsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            // Add grade column if it doesn't exist
            if (!Schema::hasColumn('reports', 'grade')) {
                $table->string('grade')->nullable();
            }
            
            // Add foreign key columns if they don't exist
            if (!Schema::hasColumn('reports', 'school_id')) {
                $table->unsignedBigInteger('school_id')->nullable();
            }
            
            if (!Schema::hasColumn('reports', 'district_id')) {
                $table->unsignedBigInteger('district_id')->nullable();
            }
            
            if (!Schema::hasColumn('reports', 'province_id')) {
                $table->unsignedBigInteger('province_id')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn(['grade', 'school_id', 'district_id', 'province_id']);        });
    }
}