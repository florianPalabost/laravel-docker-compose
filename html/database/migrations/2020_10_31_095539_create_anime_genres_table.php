<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimeGenresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anime_genre', function (Blueprint $table) {
            $table->id();
            $table->integer('anime_id')->unsigned();
            $table->integer('genre_id')->unsigned();
            $table->timestamps();

            $table->foreign('anime_id')->references('id')->on('animes')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('genre_id')->references('id')->on('genres')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anime_genre');
    }
}
