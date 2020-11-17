<?php

namespace Tests\Unit;

use App\Anime;
use App\AnimeUser;
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
    public function animeCreatedNotNull()
    {
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
    public function animeBelongToManyGenres()
    {
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
    public function animeBelongToUser()
    {
        // Given
        $user = User::factory(['id' => 12])->create();
        $anime = Anime::factory(['id' => 11])->create();

        // When
        $anime->users()->save($user, ['like' => true, 'watch' => true]);

        // Then
        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('anime_user', [
            'anime_id' => $anime->id,
            'user_id' => $user->id
        ]);
        $this->assertTrue($anime->users[0]->stat_anime->like);
        $this->assertTrue($anime->users[0]->stat_anime->watch);
        $this->assertNotTrue($anime->users[0]->stat_anime->want_to_watch);
    }
}
