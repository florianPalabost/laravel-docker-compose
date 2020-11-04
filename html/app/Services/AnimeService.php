<?php


namespace App\Services;


use App\Anime;
use App\AnimeUser;
use App\Genre;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\DB;

class AnimeService
{
    protected $logger;

    /**
     * AnimeService constructor.
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function retrieveAnimes($isPaginated = true) {
        try {
            if ($isPaginated) {
                return DB::table('animes')->whereNotNull('title')->paginate(30);
            }
            return DB::table('animes')->whereNotNull('title')->get();
        }
        catch (\Exception $e){
            $this->logger->debug($e->getMessage());
        }
    }

    public function retrieveAnime(string $title) {
        if (empty($title)) {
            return null;
        }
        return Anime::where('title', $title)->firstOrFail();
    }

    public function retrieveAnimesWithGenre($genre)
    {
        if(Anime::all()->count() > 30) {
            return Genre::where('name', $genre->name)->firstOrFail()->animes()->paginate(30);
        }
        else {
            return Genre::where('name', $genre->name)->firstOrFail()->animes()->get();
        }
    }

    public function saveUserAnimeStatus($animeId, $userId, $property)
    {
        $animeUser = new AnimeUser;
        $animeUser->anime_id = $animeId;
        $animeUser->user_id = $userId;
        $animeUser->$property = $animeUser->$property ? false: true;

        // todo rules for example if watch->true then want_to_watch->false
        switch ($property) {
            case 'like':

                break;
            case 'watch':
                break;
            case 'want_to_watch':
                break;
        }

        $animeUser->save();
        return $animeUser->wasChanged();

    }

}
