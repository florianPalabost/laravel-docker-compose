<?php

namespace Tests\Unit;

use App\Anime;
use App\Genre;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnimeModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     *
     * @test
     * @return void
     */
    public function animeHasBeenCreated()
    {
        // Given
        // When
        Anime::factory()->create();

        // Then
        $this->assertDatabaseCount('animes', 1);
    }

    /**
     * @test
     */
    public function animeCreatedNotNull() {
        // Given
        // When
        $anime = Anime::factory()->create();

        // Then
        $this->assertNotNull($anime->title);
        $this->assertNotNull($anime->anime_id);
        $this->assertNotNull($anime->id);
        $this->assertNotNull($anime->synopsis);
    }

    /**
     * test relationship between Anime & Genre with pivot table anime_genre
     * @test
     */
    public function animeBelongToManyGenres() {
        $anime = Anime::factory()
            ->has(Genre::factory()->count(3))
            ->create();

        $this->assertDatabaseCount('genres', 3);
        $this->assertDatabaseCount('anime_genre', 3);

        $this->assertTrue(count($anime->genres) === 3);
    }

    /**
     * test relationship between Anime & User with pivot table anime_user
     * @test
     */
    public function animeBelongToManyUsers() {
        $anime = Anime::factory()
            ->has(User::factory()->count(3))
            ->create();
    }
}
