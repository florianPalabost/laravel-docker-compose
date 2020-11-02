<?php

namespace App\Http\Controllers;

use App\Genre;
use App\Services\AnimeService;
use Illuminate\Http\Request;

class GenresController extends Controller
{
    protected $animeService;

    /**
     * GenresController constructor.
     * @param AnimeService $animeService
     */
    public function __construct(AnimeService $animeService)
    {
        $this->animeService = $animeService;
    }


    public function index($genreName) {
        // check if genre exist in db
        $genre = Genre::where('name', $genreName)->firstOrFail();

        if (isset($genre->name)) {
            // retrieve animes with this genre (with id)
            $animes = $this->animeService->retrieveAnimesWithGenre($genre);
        }
        // we use the view anime index to not duplicate view (see cases)
        return view('animes.index', compact('animes', 'genreName'));
    }
}
