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
                return DB::table('animes')->whereNotNull('title')->orderBy('title')->paginate(30);
            }
            return DB::table('animes')->whereNotNull('title')->orderBy('title')->get();
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

    public function retrieveLatestAnimes() {
        return DB::table('animes')->whereNotNull('title')->latest()->get();
    }

    public function retrieveAnimesWithGenre($genre)
    {
        if (empty($genre)) {
            throw new \Error('no genre pass to function');
        }
        if(Anime::count() > 30) {
            return Genre::where('name', $genre->name)->firstOrFail()->animes()->orderBy('title')->paginate(30);
        }
        else {
            return Genre::where('name', $genre->name)->firstOrFail()->animes()->orderBy('title')->get();
        }
    }

    /**
     * @param $animeId
     * @param $userId
     * @param $property string can be 'like' || 'watch' || 'want_to_watch'
     * @return bool
     */
    public function saveUserAnimeStatus($animeId, $userId, $property)
    {
        $animeUser = AnimeUser::firstOrNew(
            ['anime_id' => $animeId],
            ['user_id' => $userId],
        );
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
        return $animeUser->wasChanged() || $animeUser->wasRecentlyCreated;

    }

}
