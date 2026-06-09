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
        Schema::create('newsletters', function (Blueprint $table) {
            $table->id(); 
            $table->string('title'); 
            $table->string('category'); 
            $table->date('publish_date'); 
            $table->string('author')->nullable(); 
            
            // This holds the massive paragraph blocks for the "Read More" context
            $table->longText('full_context'); 
            
            $table->timestamps(); // automatically handles created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newsletters');
    }
};