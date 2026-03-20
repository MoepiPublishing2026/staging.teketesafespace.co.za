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
    Schema::table('reports', function (Blueprint $table) {
        // ID of the admin from your admins table
        $table->unsignedBigInteger('blocked_by_id')->nullable()->after('status');
        
        // Name of the admin (useful if the admin account is ever deleted)
        $table->string('blocked_by_name')->nullable()->after('blocked_by_id');
        
        // When the block happened
        $table->timestamp('blocked_at')->nullable()->after('blocked_by_name');

        // Optional: Add foreign key if your admin table is named 'admins'
        // $table->foreign('blocked_by_id')->references('id')->on('admins')->onDelete('set null');
    });
}

public function down(): void
{
    Schema::table('reports', function (Blueprint $table) {
        $table->dropColumn(['blocked_by_id', 'blocked_by_name', 'blocked_at']);
    });
}
};
