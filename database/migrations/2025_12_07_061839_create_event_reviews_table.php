<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('event_reviews', function (Blueprint $table) {
            $table->id();

            $table->foreignId('proposal_id')
                ->constrained('event_proposals')
                ->onDelete('cascade');

            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->unsignedTinyInteger('rating'); // 1–5
            $table->text('review')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_reviews');
    }
};
