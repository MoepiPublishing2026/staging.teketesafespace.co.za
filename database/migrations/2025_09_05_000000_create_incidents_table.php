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
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('abuse_type_id');
            $table->unsignedBigInteger('subtype_id');
            $table->text('description');
            $table->string('reporter_email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('image_path')->nullable();
            $table->string('full_name')->nullable();
            $table->string('location')->nullable();
            $table->string('school_name')->nullable();
            $table->string('case_number')->nullable()->unique();
            $table->timestamps();

            $table->foreign('abuse_type_id')->references('id')->on('abuse_types');
            $table->foreign('subtype_id')->references('id')->on('subtypes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
