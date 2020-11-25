<?php

namespace App\Http\Controllers;

use App\Anime;
use App\Exceptions\AnimeNotFoundException;
use App\Genre;
use App\Services\AnimeService;
use App\Services\GenreService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Response;
use Symfony\Component\Console\Input\Input;

class AnimesController extends Controller
{
    // TODO switch to php 7.4 for typage
    protected $animeService;

    protected $logger;

    /**
     * @var GenreService
     */
    protected $genreService;

    /**
     * AnimesController constructor.
     * @param AnimeService $animeService
     * @param GenreService $genreService
     * @param Logger $logger
     */
    public function __construct(AnimeService $animeService, GenreService $genreService, Logger $logger)
    {
        $this->animeService = $animeService;
        $this->genreService = $genreService;
        $this->logger = $logger;
    }


    /**
     * Display a listing of animes.
     *
     * @param Request $request
     * @return View|Response
     */
    public function index(Request $request)
    {
        $genres = $this->genreService->retrieveAllGenres('name');
        $filters = $request->only('genres', 'subtypes') ?? [];

        if ($request->has('genres') || $request->has('subtypes')) {
            $animes = $request->has('page') ?
                $this->animeService->retrieveAnimesWithFilters($filters, $request->get('page')) :
                $this->animeService->retrieveAnimesWithFilters($filters);
        } else {
            $animes = $this->animeService->retrieveAnimes();
        }
        $animes->appends($request->all())->links();


        // save animes retrieved in cache

        return view('animes.index', compact('animes', 'genres', 'filters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        //
        return view('animes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): \Illuminate\Http\Response
    {
        //

        return new \Illuminate\Http\Response();
    }

    /**
     * Display the specified resource.
     *
     * @param string $title
     * @return Application|Factory|View
     * @throws \Exception
     */
    public function show(string $title)
    {
        $anime = $this->animeService->retrieveAnime($title);
        if (isset($anime->anime_id)) {
            $recommendations = $this->animeService->retrieveRecommendations($anime->anime_id);
            $stat_anime = isset($anime->users) && count($anime->users) > 0 ? $anime->users[0]->stat_anime : null;
            return view('animes.show', compact('anime', 'recommendations', 'stat_anime'));
        }
        throw new AnimeNotFoundException('No anime with title ' . $title);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function edit(int $id)
    {
        return view('animes.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id): \Illuminate\Http\Response
    {
        //

        return new \Illuminate\Http\Response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return void
     */
    public function destroy(int $id)
    {
        //
    }

    public function searchAnimes(Request $request)
    {
        if ($request->get('q') && strlen($request->get('q')) > 1) {
            $animes = $this->animeService->retrieveLikeAnimes($request->get('q'));
            // add search value to the url pagination
            $animes->appends(['q' => $request->get('q')])->links();

            // check if request is ajax or not with this header
            if ($request->hasHeader('X-Requested-With')) {
                return count($animes) > 0 ? $animes : [];
            }
            return view('animes.result-search', compact('animes'));
        }
        return [];
    }
}
