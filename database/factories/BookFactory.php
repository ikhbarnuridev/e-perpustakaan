<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'cover' => fake()->optional()->imageUrl(640, 480, 'books', true, 'Cover'),
            'author' => fake()->name(),
            'publisher' => fake()->company(),
            'year_published' => fake()->year(),
            'stock' => fake()->numberBetween(1, 50),
        ];
    }
}
