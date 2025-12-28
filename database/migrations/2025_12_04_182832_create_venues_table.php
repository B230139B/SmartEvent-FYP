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
        Schema::create('venues', function (Blueprint $table) {
            $table->id();

            // Basic venue information
            $table->string('name');                    // Venue name
            $table->string('location')->nullable();    // Johor Bahru, Batu Pahat, etc.
            
            // Venue details
            $table->integer('capacity')->nullable();   // Number of people it can hold
            $table->decimal('price', 10, 2)->nullable(); // Price in RM (decimal for cents)
            
            // Additional information
            $table->text('description')->nullable();   // Optional details
            $table->string('image')->nullable();       // Image file name stored in /storage/app/public/venues/

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venues');
    }
};
