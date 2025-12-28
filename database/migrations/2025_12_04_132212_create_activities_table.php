<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();

            // Basic activity information
            $table->string('name'); 
            $table->text('description')->nullable();

            // Recommended budget range (optional)
            $table->integer('recommended_min_budget')->nullable();
            $table->integer('recommended_max_budget')->nullable();

            // Recommended number of people (optional)
            $table->integer('recommended_people_min')->nullable();
            $table->integer('recommended_people_max')->nullable();

            // Activity image path
            $table->string('image')->nullable(); 
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('activities');
    }
};
