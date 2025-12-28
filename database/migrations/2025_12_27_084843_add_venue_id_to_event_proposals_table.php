<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('event_proposals', function (Blueprint $table) {
            // 1️⃣ Add column as nullable FIRST
            $table->unsignedBigInteger('venue_id')
                  ->nullable()
                  ->after('people');
        });

        Schema::table('event_proposals', function (Blueprint $table) {
            // 2️⃣ Add foreign key AFTER column exists
            $table->foreign('venue_id')
                  ->references('id')
                  ->on('venues')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('event_proposals', function (Blueprint $table) {
            $table->dropForeign(['venue_id']);
            $table->dropColumn('venue_id');
        });
    }
};
