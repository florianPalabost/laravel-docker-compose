<?php

namespace App\Http\Controllers;

use App\Anime;
use App\Jobs\ImportAnime;
use App\Services\AnimeService;
use GuzzleHttp\Client;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('animes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param $title
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Exception
     */
    public function show($title)
    {
        $anime = $this->animeService->retrieveAnime($title);
        if (isset($anime)) {
            $client = new Client();
            $uri = env('API_LINK') . $anime->anime_id . '/recommendations';
            $promise = $client->getAsync($uri);
            $response = $promise->wait();
            $content = $response->getBody(true)->getContents();
            $content = json_decode($content);
            $recommendations = $content->recommendations;

            return view('animes.show', compact('anime', 'recommendations'));
        }
        else {
            throw new \Exception('No anime with title ' . $title);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
