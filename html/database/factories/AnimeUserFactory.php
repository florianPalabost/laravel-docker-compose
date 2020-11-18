<?php

namespace Database\Factories;

use App\AnimeUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnimeUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AnimeUser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => rand(0,155),
            'anime_id' => 10,
            'user_id' => 10,
            'like' => false,
            'watch' => false,
            'want_to_watch' => false,
        ];
    }
}
