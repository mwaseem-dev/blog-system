<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'      => User::factory(),
            'title'        => fake()->sentence(),
            'body'         => fake()->paragraphs(3, true),
            'status'       => 'published',
            'published_at' => now()->subMinute(),
        ];
    }

    public function draft(): static
    {
        return $this->state(['status' => 'draft', 'published_at' => null]);
    }

    public function scheduled(): static
    {
        return $this->state([
            'status'       => 'scheduled',
            'published_at' => now()->addDay(),
        ]);
    }
}
