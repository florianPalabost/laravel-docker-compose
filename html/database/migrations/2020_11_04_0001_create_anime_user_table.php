<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimeUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anime_user', function (Blueprint $table) {
            $table->id();
            $table->integer('anime_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->boolean('like')->default(false);
            $table->boolean('watch')->default(false);
            $table->boolean('want_to_watch')->default(false);
            $table->timestamps();

            $table->foreign('anime_id')->references('id')->on('animes')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::dropIfExists('anime_user');
    }
}
