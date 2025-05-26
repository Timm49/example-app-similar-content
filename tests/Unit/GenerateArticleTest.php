<?php

namespace Tests\Unit;

use App\Enums\CategoryType;
use App\Jobs\GenerateArticle;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Responses\Chat\CreateResponse;
use Tests\TestCase;

class GenerateArticleTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_generates_an_article()
    {
        $articles = Article::factory()->count(3)->create();
        // Mock the OpenAI response
        OpenAI::fake([
            CreateResponse::fake([
                'choices' => [
                    [
                        'message' => [
                            'role' => 'assistant',
                            'content' => json_encode([
                                'title' => 'Test Article',
                                'content' => 'Test content',
                                'author' => 'Test Author',
                                'category' => 'sports',
                                'keywords' => ['football', 'championship', 'victory']
                            ])
                        ]
                    ]
                ]
            ])
        ]);

        // Dispatch the job
        GenerateArticle::dispatch();

        // Assert that an article was created
        $this->assertDatabaseHas('articles', [
            'title' => 'Test Article',
            'slug' => 'test-article',
            'content' => 'Test content',
            'author' => 'Test Author',
            'category' => 'sports',
            'keywords' => json_encode(['football', 'championship', 'victory'])
        ]);
    }
}
