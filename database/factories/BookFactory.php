<?php
namespace Database\Factories;
use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;
class BookFactory extends Factory {
    public function definition(): array {
        return [
            'author_id' => Author::factory(),
            'title' => fake()->realText(20),
            'description' => fake()->realText(100),
            'file_path' => null,
            'status' => fake()->numberBetween(1, 2),
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'view_count' => fake()->numberBetween(0, 5000),
        ];
    }
}
