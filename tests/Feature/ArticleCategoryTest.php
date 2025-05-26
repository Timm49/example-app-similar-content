<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use App\Enums\CategoryType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleCategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_article()
    {
        $article = Article::factory()->create([
            'title' => 'Test Article',
            'slug' => 'test-article',
            'content' => 'Test content',
            'author' => 'Test Author',
            'category' => CategoryType::SPORTS->value
        ]);

        $this->assertEquals(CategoryType::SPORTS->value, $article->category);
    }
}
