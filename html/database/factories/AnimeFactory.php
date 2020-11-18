<?php

namespace Database\Factories;

use App\Anime;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AnimeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Anime::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'anime_id' => rand(0,50000),
            'title' => Str::random(55),
            'synopsis' => Str::random(100),
            'rating' => rand(0,10),
            'start_date' => now()->toDateString(),
            'end_date' => now()->toDateString(),
            'subtype' => 'TV',
            'status' => 'finished',
            'poster_image' => 'https://placehold.com',
            'episode_count' => 12,
            'youtube_video_id' => 'https://youtube.com',
        ];
    }
}
