<?php

namespace App\Http\Controllers;

use App\Exceptions\AnimeNotFoundException;
use App\Services\AnimeService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Response;

class AnimesController extends Controller
{
    // TODO switch to php 7.4 for typage
    protected $animeService;

    protected $logger;

    /**
     * AnimesController constructor.
     * @param AnimeService $animeService
     * @param Logger $logger
     */
    public function __construct(AnimeService $animeService, Logger $logger)
    {
        $this->animeService = $animeService;
        $this->logger = $logger;
    }


    /**
     * Display a listing of animes.
     *
     * @return View|Response
     */
    public function index()
    {
        $animes = $this->animeService->retrieveAnimes();

        // save animes retrieved in cache

        // filters ?

        // user ?
        return view('animes.index', compact('animes'));
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
            $user = auth()->user();
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
}
