<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activity_event_proposal', function (Blueprint $table) {

            if (!Schema::hasColumn('activity_event_proposal', 'event_proposal_id')) {
                $table->unsignedBigInteger('event_proposal_id')->after('id');
            }

            if (!Schema::hasColumn('activity_event_proposal', 'activity_id')) {
                $table->unsignedBigInteger('activity_id')->after('event_proposal_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('activity_event_proposal', function (Blueprint $table) {
            $table->dropColumn(['event_proposal_id', 'activity_id']);
        });
    }
};
