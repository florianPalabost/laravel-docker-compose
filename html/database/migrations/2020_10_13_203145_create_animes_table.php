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
            $table->string('startDate')->nullable();
            $table->string('endDate')->nullable();
            $table->enum('subtype', ['ONA', 'OVA', 'TV', 'Movie', 'Music', 'special'])->nullable();
            $table->enum('status', ['current', 'finished', 'tba', 'unreleased', 'upcoming'])->nullable();
            $table->string('posterImage')->nullable();
            $table->string('coverImage')->nullable();
            $table->integer('episodeCount')->nullable();
            $table->string('episodeLength')->nullable();
            $table->string('youtubeVideoId')->nullable();
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
