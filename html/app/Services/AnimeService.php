<?php


namespace App\Services;


use App\Anime;
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
        // todo check we have at least 30 animes !
        return Genre::where('name', $genre->name)->firstOrFail()->animes()->paginate(30);
    }

}
