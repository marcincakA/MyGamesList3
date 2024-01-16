<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'developer' => fake()->name(),
            'publisher' => fake()->name(),
            'category1' => fake()->word(),
            'category2' => fake()->word(),
            'category3' => fake()->word(),
            'about' => fake()->sentence(),
            'image' => fake()->imageUrl(),
        ];
    }
}
