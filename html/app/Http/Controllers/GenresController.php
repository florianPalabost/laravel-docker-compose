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

        $animes = isset($genre->name) ? $this->animeService->retrieveAnimesWithGenre($genre) : null;

        // we use the view anime index to not duplicate view (see cases)
        return view('animes.index', compact('animes', 'genreName'));
    }
}
