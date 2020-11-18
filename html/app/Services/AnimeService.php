<?php

namespace App\Services;

use App\Anime;
use App\AnimeUser;
use App\Exceptions\AnimeNotFoundException;
use App\Exceptions\PropertyNotFoundException;
use App\Genre;
use DeepCopy\Exception\PropertyException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Routing\Exception\InvalidParameterException;

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

    public function retrieveAnimes($isPaginated = true)
    {
        try {
            $animes = DB::table('animes')->whereNotNull('title')->orderBy('title');
            return $isPaginated ? $animes->paginate(30) : $animes->get();
        } catch (ModelNotFoundException $e) {
            return back()->withErrors($e->getMessage());
        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
            return back()->withErrors($e->getMessage());
        }
    }

    public function retrieveAnime(string $title)
    {
        if (empty($title)) {
            return null;
        }
        try {
            return Anime::where('title', $title)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function retrieveLatestAnimes()
    {
        try {
            return DB::table('animes')->whereNotNull('title')->latest()->get();
        } catch (ModelNotFoundException $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function retrieveAnimesWithGenre($genre)
    {
        if (empty($genre)) {
            throw new \Error('no genre pass to function');
        }
        if (Anime::count() > 30) {
            return Genre::where('name', $genre->name)->firstOrFail()->animes()->orderBy('title')->paginate(30);
        } else {
            return Genre::where('name', $genre->name)->firstOrFail()->animes()->orderBy('title')->get();
        }
    }


    /**
     * @param int $animeId
     * @param int $userId
     * @param string $property
     * @return mixed
     * @throws PropertyNotFoundException
     */
    public function saveUserAnimeStatus(int $animeId, int $userId, string $property)
    {
        if (empty($animeId) || empty($userId) || empty($property)) {
            throw new InvalidParameterException(' Wrong Anime id or User id or property ');
        }
        try {
            $animeUser = AnimeUser::firstOrNew(
                ['anime_id' => $animeId],
                ['user_id' => $userId],
            );
        } catch (AnimeNotFoundException $e) {
            return back()->withErrors($e->getMessage());
        }

        $animeUser->$property = $animeUser->$property ? false : true;

        switch ($property) {
            case 'like':
                if ($animeUser->like) {
                    $animeUser->watch = true;
                    $animeUser->want_to_watch = false;
                }
                break;
            case 'watch':
                if ($animeUser->watch) {
                    $animeUser->want_to_watch = false;
                }
                break;
            case 'want_to_watch':
                if ($animeUser->want_to_watch) {
                    $animeUser->watch = false;
                    $animeUser->like = false;
                }
                break;
            default:
                throw new PropertyNotFoundException(' This property is not supported : ' . $property);
        }
        $animeUser->save();
        return $animeUser;
    }
}
