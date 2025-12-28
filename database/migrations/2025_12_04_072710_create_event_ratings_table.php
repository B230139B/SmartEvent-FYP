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
        Schema::create('event_ratings', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->foreignId('event_proposal_id')
                  ->constrained('event_proposals')
                  ->onDelete('cascade');

            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Rating data
            $table->integer('rating'); // 1–5 stars
            $table->text('comment')->nullable(); // optional comment

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_ratings');
    }
};
