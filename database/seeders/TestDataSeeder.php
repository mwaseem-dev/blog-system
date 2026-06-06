<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'john@example.com'],
            ['name' => 'John Doe', 'password' => bcrypt('password123')]
        );

        Post::create([
            'user_id' => $user->id,
            'title' => 'Welcome to My Blog!',
            'body' => 'This is my first published post. I am excited to share my thoughts and ideas with you all. Feel free to leave comments and likes on my posts!',
            'status' => 'published',
            'published_at' => now(),
        ]);

        Post::create([
            'user_id' => $user->id,
            'title' => 'Getting Started with Laravel',
            'body' => 'Laravel is an amazing PHP framework that makes web development a breeze. In this post, I will share some tips and tricks for getting started with Laravel and building great applications.',
            'status' => 'published',
            'published_at' => now()->subDay(),
        ]);

        Post::create([
            'user_id' => $user->id,
            'title' => 'Database Design Best Practices',
            'body' => 'Having a well-structured database is crucial for any application. Let me share some best practices I have learned over the years developing web applications.',
            'status' => 'published',
            'published_at' => now()->subDays(2),
        ]);
    }
}
