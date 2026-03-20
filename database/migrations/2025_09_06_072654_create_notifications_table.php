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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            // Using foreignId() to ensure the column type matches the primary key of the incidents table
            $table->foreignId('report_id')->constrained('incidents')->onDelete('cascade');
            $table->enum('notification_type', ['OTP', 'CaseUpdate', 'General']);
            $table->text('message');
            $table->string('phone_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
