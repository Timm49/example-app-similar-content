<?php

namespace App\Jobs;

use App\Enums\CategoryType;
use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use OpenAI\Laravel\Facades\OpenAI;

class GenerateArticle implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $response = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are an author for a news organization. You write news articles for their website. Generate a news article in JSON format with the following fields: title, content, author, category, and keywords. The category should be one of: ' . implode(', ', array_column(CategoryType::cases(), 'value')) . '. Include 1-3 relevant keywords as an array for the article.'.
                        'Make sure to write something totally different from these news articles which we already have so we have a broad selection of topics. These titles are already in our database: ' . json_encode(Article::all()->pluck('title'))
                ],
                [
                    'role' => 'user',
                    'content' => 'Write a (typical) news article with original content'
                ]
            ]
        ]);

        $article = json_decode($response->choices[0]->message->content, true);
        if (!isset($article['title'])) {
            throw new \Exception('Failed to generate article title. ' . json_encode($response->choices));
        }
        Article::create([
            'title' => $article['title'],
            'slug' => Str::slug($article['title']),
            'content' => $article['content'],
            'author' => $article['author'],
            'category' => $article['category'],
            'keywords' => $article['keywords']
        ]);
    }
}
