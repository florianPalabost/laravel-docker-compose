<?php

namespace Tests\Unit;

use App\Anime;
use App\AnimeGenre;
use App\Genre;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GenreModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
     */
    public function genreHasBeenCreatedAndPersisted()
    {
        Genre::factory()->create();
        $this->assertDatabaseCount('genres', 1);
    }

    /**
     * @test
     * @return void
     */
    public function genreCreatedIsNotNull()
    {
        $genre = Genre::factory()->create();
        $this->assertNotNull($genre->id);
        $this->assertNotNull($genre->name);
    }

    /**
     * @test
     * @return void
     */
    public function genreShouldHaveAnimes()
    {
        $genre = Genre::factory(['id' => 10])->has(
            Anime::factory()->count(3)->state(new Sequence(
                ['id' => 1],
                ['id' => 2],
                ['id' => 3],
            ))
        )->create();

        $animeGenre1 = AnimeGenre::where('anime_id', 1)->where('genre_id', 10)->get();
        $animeGenre2 = AnimeGenre::where('anime_id', 2)->where('genre_id', 10)->get();
        $animeGenre3 = AnimeGenre::where('anime_id', 3)->where('genre_id', 10)->get();

        $this->assertNotNull($animeGenre1);
        $this->assertNotNull($animeGenre2);
        $this->assertNotNull($animeGenre3);

        $this->assertEquals(3, Anime::count());
        $this->assertEquals(1, Genre::count());
        $this->assertDatabaseCount('anime_genre', 3);

        $this->assertCount(3, $genre->animes);
    }
}
