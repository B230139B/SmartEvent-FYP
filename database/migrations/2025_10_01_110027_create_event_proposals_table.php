<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_proposals', function (Blueprint $table) {
            $table->id();

            // User
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Event details
            $table->string('event_name');
            $table->date('event_date')->nullable();
            $table->decimal('budget', 10, 2);
            $table->integer('people')->nullable();

            // Venue (FK)
            $table->foreignId('venue_id')
                  ->constrained('venues')
                  ->onDelete('cascade');

            // Description
            $table->text('description')->nullable();

            // Admin review
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])
                  ->default('Pending');
            $table->text('admin_feedback')->nullable();

            // Publishing
            $table->boolean('is_published')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_proposals');
    }
};
