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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();

            // Minimum budget amount (in RM)
            $table->integer('min_amount')->default(0);

            // Maximum budget amount (nullable = no upper limit)
            $table->integer('max_amount')->nullable();

            // Recommended event type (ex: "Wedding", "Corporate Dinner")
            $table->string('suitable_event')->nullable();

            // Estimated number of people (ex: 300, 500, 1000 people)
            $table->integer('estimated_capacity')->nullable();

            // Additional details/notes
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
