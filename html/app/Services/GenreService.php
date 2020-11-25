<?php

namespace App\Services;

use App\Genre;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Log\Logger;

class GenreService
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
     * @param string $namePlug
     * @return Genre[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|string
     */
    public function retrieveAllGenres(string $namePlug)
    {
        try {
            return !empty($namePlug) ? Genre::all()->pluck($namePlug) : Genre::all();
        } catch (ModelNotFoundException $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param string $name
     * @return Genre
     */
    public function retrieveByName(string $name): Genre
    {
        return Genre::where('name', $name)->firstOrFail();
    }
}
