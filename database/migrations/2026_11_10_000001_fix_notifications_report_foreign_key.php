<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('notifications') || DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement('ALTER TABLE notifications DROP FOREIGN KEY notifications_report_id_foreign');

        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign(['report_id']);
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->foreign('report_id')
                ->references('id')
                ->on('reports')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('notifications') || DB::getDriverName() !== 'mysql') {
            return;
        }

        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign(['report_id']);
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->foreign('report_id')
                ->references('id')
                ->on('incidents')
                ->onDelete('cascade');
        });
    }
};
