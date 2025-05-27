<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Inertia\Inertia;
use Inertia\Response;
use Timm49\LaravelSimilarContent\SimilarContent;
use Timm49\LaravelSimilarContent\SimilarContentResult;

class ArticleController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Welcome', [
            'articles' => Article::latest()->get()
        ]);
    }

    public function show(Article $article): Response
    {
        $similarContent = collect(SimilarContent::for($article)
            ->getSimilarContent())
            ->take(5);

        return Inertia::render('Articles/Show', [
            'article' => $article,
            'similar_content' => $similarContent->map(function (SimilarContentResult $item) {
                $similarItem = Article::find($item->targetId);
                return [
                    'title' => $similarItem->title,
                    'slug' => $similarItem->slug,
                    'author' => $similarItem->author,
                    'published_at' => $similarItem->published_at,
                    'category' => $similarItem->category,
                    'similarity_score' => $item->similarityScore,
                    'content' => $similarItem   ->content,
                    'keywords' => implode(",", $similarItem->keywords),
                ];
            })
        ]);
    }
}
