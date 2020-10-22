<?php


namespace App\Services;


use App\Anime;
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

    public function retrieveAnimes() {
        try {
            return DB::table('animes')->whereNotNull('title')->paginate(30);
        }
        catch (\Exception $e){
            $this->logger->debug($e->getMessage());
        }
    }

    public function retrieveAnime(string $title) {
        if (empty($title)) {
            return null;
        }
        return DB::table('animes')->where('title', $title)->first();
    }

}
