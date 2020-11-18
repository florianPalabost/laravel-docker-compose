<?php

namespace Tests\Unit;

use App\Anime;
use App\AnimeUser;
use App\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
     */
    public function userCreated()
    {
        User::factory()->create();
        $this->assertEquals(1, User::count());
    }

    /**
     * @test
     * @return void
     */
    public function userShouldHaveAnimes()
    {
        $user = User::factory(['id' => 1])->has(
            Anime::factory()->count(3)->state(new Sequence(
                ['id' => 10],
                ['id' => 20],
                ['id' => 30],
            ))
        )->create();
        $userAnime1 = AnimeUser::where('anime_id', 10)->where('user_id', 1)->get();
        $userAnime2 = AnimeUser::where('anime_id', 20)->where('user_id', 1)->get();
        $userAnime3 = AnimeUser::where('anime_id', 30)->where('user_id', 1)->get();

        $this->assertEquals(1, User::count());
        $this->assertEquals(3, Anime::count());
        $this->assertEquals(3, AnimeUser::count());

        $this->assertNotNull($userAnime1);
        $this->assertNotNull($userAnime2);
        $this->assertNotNull($userAnime3);

        $this->assertEquals(3, count($user->animes));
    }
}
