<?php

namespace Database\Factories;

use App\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

class GenreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Genre::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => rand(0,155),
            'name' => $this->faker->name,
            'description' => $this->faker->description
        ];
    }
}