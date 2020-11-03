<?php

namespace App\Jobs;

use App\Anime;
use App\AnimeGenre;
use App\Genre;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImportAnime implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Anime
     */
    protected $anime;

    /**
     * Create a new job instance.
     *
     * @param Anime $anime
     */
    public function __construct(Anime $anime)
    {
        $this->anime = $anime;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (isset($this->anime->anime_id)) {
            $testAnime = DB::table('animes')->where('anime_id', $this->anime->anime_id)->first();
            if ($testAnime !== null && isset($testAnime->anime_id)) {
                if(isset($testAnime->title)) {
                    Log::debug($testAnime->title . ' with id :  ' . $testAnime->anime_id . ' already imported !');
                    return;
                }
            }

            $client = new Client();
            $uri = env('API_LINK') . $this->anime->anime_id;
            // we need to wait 4s because of the api doc
            sleep(4);
            Log::debug('call ::::' . $uri);
            $promise = $client->getAsync($uri);
            $response = $promise->wait();

            $content = $response->getBody(true)->getContents();
            $content = json_decode($content);

            // transform result to rpz Anime model
            // save in db
            $this->updateAttributes($this->anime, $content);
        }


    }

    public function updateAttributes(Anime $anime, $content) {
        // TODO properties in //
        $anime->title = $content->title ?? null;
        $anime->synopsis = $content->synopsis ?? null;
        $anime->rating = $content->score ?? null;
        $anime->start_date = $content->aired->prop->from->year ?? null;
        $anime->end_date = $content->aired->prop->to->year ?? null;
        $anime->subtype = $content->type ?? null;
//        $anime->status = $content->status;
        $anime->poster_image = $content->image_url ?? null;
        $anime->episode_count = $content->episodes ?? null;
        $anime->episode_length = $content->duration ?? null;
        $anime->youtube_video_id = $content->trailer_url ?? null;

        if (count($content->genres) > 0) {
            $this->updateGenresAnime($content->genres, $anime);
        }

        $anime->save();

        $anime->waschanged() ? Log::info($anime->title. ' : updated !') :
            Log::info($anime->title. ' : NOT updated !');
    }

    public function updateGenresAnime($genres, $anime) {
        foreach ($genres as $genre) {
            // check if genre already recorded in db
            $genreDb = DB::table('genres')->where('name', $genre->name)->first();
            if (isset($genreDb->id) && !empty($genreDb->id)) {
                // check if we already have a record with this anime id and this genre_id
                $genreAnimeId = DB::table('anime_genre')->where('anime_id', $anime->id)
                    ->where('genre_id', $genreDb->id)->get();
                if(isset($genreAnimeId->id) && !empty($genreAnimeId->id)) {
                    continue;
                }
                else {
                    // this association of anime id & genre id doent exist, we create it
                    $anime->genres()->attach($genreDb->id);
                }
            }
            else {
                // genre not exist in db so we create it
                $newGenre = new Genre([
                    'name' => $genre->name
                ]);
                $newGenre->save();
                Log::debug('New genre add : ' . $genre->name);

                // get the anime id newly recorded
                $newGenreDb = DB::table('genres')->where('name', $genre->name)->first();
                // we add relation anime id genre id
                $anime->genres()->attach($newGenreDb->id);
            }
        }
    }
}
