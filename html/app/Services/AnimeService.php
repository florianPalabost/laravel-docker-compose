<?php

namespace App\Services;

use App\Anime;
use App\AnimeUser;
use App\Exceptions\AnimeNotFoundException;
use App\Exceptions\PropertyNotFoundException;
use App\Genre;
use GuzzleHttp\Client;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Log\Logger;
use Illuminate\Support\Collection;
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

    /**
     * @param bool $isPaginated
     * @return LengthAwarePaginator|Collection|string
     */
    public function retrieveAnimes($isPaginated = true)
    {
        try {
            $animes = DB::table('animes')->whereNotNull('title')->orderBy('title');
            return $isPaginated ? $animes->paginate(30) : $animes->get();
        } catch (ModelNotFoundException $e) {
            return $e->getMessage();
        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
            return $e->getMessage();
        }
    }

    /**
     * @param string $title
     * @return Anime|string
     */
    public function retrieveAnime(string $title)
    {
        if (empty($title)) {
            throw new \Error('No title pass to function');
        }
        try {
            return Anime::where('title', $title)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return $e->getMessage();
        }
    }

    /**
     * @return Collection|string
     */
    public function retrieveLatestAnimes()
    {
        try {
            return DB::table('animes')->whereNotNull('title')->latest()->get();
        } catch (ModelNotFoundException $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param  Genre $genre
     * @return Collection|string
     */
    public function retrieveAnimesWithGenre(Genre $genre)
    {
        if (empty($genre)) {
            throw new \Error('no genre pass to function');
        }
        try {
            $animes = Genre::where('name', $genre->name)->firstOrFail()->animes()->orderBy('title');
            return Anime::count() > 30 ? $animes->paginate(30) : $animes->get();
        } catch (AnimeNotFoundException | ModelNotFoundException $e) {
            return $e->getMessage();
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
            return $e->getMessage();
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

    /**
     * @param string $animeId
     * @return string|mixed|null
     */
    public function retrieveRecommendations(string $animeId)
    {
        if (empty($animeId)) {
            return null;
        }

        try {
            $client = new Client();
            $uri = env('API_LINK') . $animeId . '/recommendations';
            $promise = $client->getAsync($uri);
            $response = $promise->wait();
            $content = $response->getBody(true)->getContents();
            $content = json_decode($content);
            return $content->recommendations;
        } catch (HttpClientException $e) {
            return $e->getMessage();
        }
    }
}
