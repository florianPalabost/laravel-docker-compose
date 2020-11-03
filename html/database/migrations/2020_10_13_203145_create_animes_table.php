<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->longText('synopsis')->nullable();
            $table->string('rating')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->enum('subtype', ['ONA', 'OVA', 'TV', 'Movie', 'Music', 'special', 'Special', 'tv'])->nullable();
            $table->enum('status', ['current', 'finished', 'tba', 'unreleased', 'upcoming'])->nullable();
            $table->string('poster_image')->nullable();
            $table->string('cover_image')->nullable();
            $table->integer('episode_count')->nullable();
            $table->string('episode_length')->nullable();
            $table->string('youtube_video_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('animes');
    }
}
