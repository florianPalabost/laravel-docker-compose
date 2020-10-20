<?php

namespace App\Jobs;

use App\Anime;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
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
        $client = new Client();
        $uri = env('API_LINK') . $this->anime->anime_id;

        Log::debug('call ::::' . $uri);
        $promise = $client->getAsync($uri);
        $response = $promise->wait();
        $content = $response->getBody(true)->getContents();
        $content = json_decode($content);

        // transform result to rpz Anime model
        // save in db
        $this->updateAttributes($this->anime, $content);

    }

    public function updateAttributes(Anime $anime, $content) {
        // TODO properties in //
        $anime->title = $content->title;
        $anime->synopsis = $content->synopsis;
        $anime->rating = $content->score;
        $anime->startDate = $content->aired->prop->from->year;
        $anime->endDate = $content->aired->prop->to->year;
//        $anime->subtype = $content->type;
//        $anime->status = $content->status;
        $anime->posterImage = $content->image_url;
        $anime->episodeCount = $content->episodes;
//        $anime->episodeLength = $content->duration;
        $anime->youtubeVideoId = $content->trailer_url;

        $anime->save();

        $anime->waschanged() ? Log::info($anime->title. ' : updated !') :
            Log::info($anime->title. ' : NOT updated !');
    }
}
