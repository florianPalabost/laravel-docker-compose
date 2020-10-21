<?php


namespace App\Services;


use App\Anime;
use Illuminate\Support\Facades\DB;

class AnimeService
{
    /**
     * AnimeService constructor.
     */
    public function __construct()
    {
    }

    public function retrieveAnimes() {
        return Anime::all()->where('title', '!==', null);
    }

    public function retrieveAnime(string $title) {
        $res = DB::table('animes')->where('title', $title)->first();
        dd($res);

        return $res;
    }

}
