<?php

namespace App\Http\Controllers;

use App\Anime;
use App\Jobs\ImportAnime;
use App\Services\AnimeService;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Log\Logger;
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
     */
    public function show($title)
    {
        $anime = $this->animeService->retrieveAnime($title);
        return view('animes.show', compact('anime'));
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

    // TODO route only with admin access
    public function import() {
        set_time_limit(6000);
        // get all ids for import animes with jitsu api thanks to a json map file
        $content = $this->retrieveJson();

        for ($i = 0;$i < count($content); $i++)  {
            $id = strval($content[$i]['mal_id']);
            // add id to queue
            $this->logger->debug('start : ' . $id);
            $tmpAnime = new Anime();
            $tmpAnime->anime_id = $id;
            try {
                // check if anime already exist -> delete it
                $oldAnime =DB::table('animes')->where('anime_id','=', $id)->get();
                if(count($oldAnime) > 0) {
                    Anime::destroy($oldAnime->get('id'));
                }
                $tmpAnime->saveOrFail();
                $this->dispatch(new ImportAnime($tmpAnime));
            }
            catch (\Exception $e) {
                $this->logger->error($e);
            } catch (\Throwable $err) {
                $this->logger->error($err);
            }
        }

        return view('welcome');
    }

    private function retrieveJson() {
        try {
            $json = Storage::disk('local')->get('animeMapping_full.json');
            return json_decode($json, true);
        } catch (FileNotFoundException $e) {
            $this->logger->error($e);
            return $e;
        }
    }
}
