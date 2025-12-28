<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('community_posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');      // who posted
            $table->string('event_title');               // name of event
            $table->text('description')->nullable();     // event details
            $table->integer('rating')->default(0);       // 1–5 stars
            $table->string('image')->nullable();         // optional event photo
            $table->boolean('approved')->default(false); // admin approval
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('community_posts');
    }
};
