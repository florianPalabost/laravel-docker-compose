<?php

namespace Tests\Unit;

use App\Anime;
use App\Genre;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnimeModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
     */
    public function animeHasBeenCreated()
    {
        // Given
        Anime::factory()->create();
        // When
        // Then
        $this->assertDatabaseCount('animes', 1);
    }

    /**
     * @test
     * @return void
     */
    public function animeWithWrongSubtypeShouldNotHaveBeenCreated()
    {
        $this->expectException(QueryException::class);
        Anime::factory(['subtype' => 'toto_subtype'])->create();
        $this->assertEquals(0, Anime::count());
    }

    /**
     * @test
     * @return void
     */
    public function animeWithWrongStatusShouldNotHaveBeenCreated()
    {
        $this->expectException(QueryException::class);
        Anime::factory(['status' => 'toto_status'])->create();
        $this->assertEquals(0, Anime::count());
    }


    /**
     * @test
     */
    public function animeCreatedNotNull()
    {
        // Given
        $anime = Anime::factory()->create();
        // When
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
        $this->assertEquals(3, count($anime->genres));
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
