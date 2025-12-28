<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('budgets', function (Blueprint $table) {

            // Remove old unused columns (if they exist)
            if (Schema::hasColumn('budgets', 'min_amount')) {
                $table->dropColumn('min_amount');
            }

            if (Schema::hasColumn('budgets', 'max_amount')) {
                $table->dropColumn('max_amount');
            }

            if (Schema::hasColumn('budgets', 'suitable_event')) {
                $table->dropColumn('suitable_event');
            }

            if (Schema::hasColumn('budgets', 'estimated_capacity')) {
                $table->dropColumn('estimated_capacity');
            }

            if (Schema::hasColumn('budgets', 'notes')) {
                $table->dropColumn('notes');
            }

            // Add correct columns for SmartEvent system
            $table->string('range')->after('id');
            $table->string('recommended_event')->after('range');
            $table->text('details')->nullable()->after('recommended_event');
        });
    }

    public function down()
    {
        Schema::table('budgets', function (Blueprint $table) {

            $table->dropColumn([
                'range',
                'recommended_event',
                'details',
            ]);

            // Optional rollback (not required for FYP demo)
            $table->decimal('min_amount', 10, 2)->nullable();
            $table->decimal('max_amount', 10, 2)->nullable();
            $table->string('suitable_event')->nullable();
            $table->integer('estimated_capacity')->nullable();
            $table->text('notes')->nullable();
        });
    }
};
