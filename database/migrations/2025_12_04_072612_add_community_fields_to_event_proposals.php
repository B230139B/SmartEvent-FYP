<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('event_proposals', function (Blueprint $table) {
        $table->boolean('is_published')->default(false);
        $table->float('rating')->default(0);
        $table->integer('ratings_count')->default(0);
        $table->text('community_description')->nullable();
    });
}

public function down()
{
    Schema::table('event_proposals', function (Blueprint $table) {
        $table->dropColumn([
            'is_published',
            'rating',
            'ratings_count',
            'community_description'
        ]);
    });
}

};
