<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Article;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Read the JSON file
        $json = File::get(database_path('articles.json'));
        $articles = json_decode($json, true);

        // Create articles from JSON data
        foreach ($articles as $articleData) {
            Article::create([
                'title' => $articleData['title'],
                'slug' => $articleData['slug'],
                'content' => $articleData['content'],
                'author' => $articleData['author'],
                'category' => $articleData['category'],
                'status' => 'published',
                'published_at' => now(),
            ]);
        }
    }
}
