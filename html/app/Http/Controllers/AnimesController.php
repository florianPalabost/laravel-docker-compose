<?php

namespace App\Http\Controllers;

use App\Anime;
use App\Exceptions\AnimeNotFoundException;
use App\Genre;
use App\Services\AnimeService;
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
     * @param Request $request
     * @return View|Response
     */
    public function index(Request $request)
    {

        //todo service
        $genres = Genre::all()->pluck('name');
        $filters = $request->get('filters') ?? [];

        if ($request->has('filters')) {
            $query = array_key_exists('genres', $request->get('filters')) ?
                Anime::with('genres') : Anime::query();

            $query = $query->filterBy($request->get('filters'));

            $animes = $request->has('page') ?
                $query->paginate(30, ['*'], 'page', $request->get('page')) :
                $query->paginate(30);
        } else {
            $animes = $this->animeService->retrieveAnimes();
        }

        $animes->appends($request->all())->links();


        // save animes retrieved in cache

        // user ?
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

    // todo use index animes route on get (form method)
    public function applyFiltersAnimes(Request $request)
    {
        try {
            $filters = $request->only('genres', 'subtypes');
//            $animes = $this->animeService->retrieveAnimesWithFilters($filters);
//            $animes->appends($filters)->links();
            return redirect()->route('animes.index', [ 'filters' => $filters]);
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function searchAnimes(Request $request)
    {
        if ($request->get('q') && strlen($request->get('q')) > 1) {
            $animes = $this->animeService->retrieveLikeAnimes($request->get('q'));
            return count($animes) > 0 ? $animes : [];
        }
        return [];
    }
}
