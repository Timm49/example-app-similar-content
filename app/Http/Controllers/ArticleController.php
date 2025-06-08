<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Inertia\Response;
use Timm49\SimilarContentLaravel\Facades\SimilarContent;
use Timm49\SimilarContentLaravel\SimilarContentResult;

class ArticleController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Articles/Index', [
            'articles' => Article::latest()->get(),
            'searchResults' => $this->getSearchResults($request)
        ]);
    }

    public function show(Article $article): Response
    {
        return Inertia::render('Articles/Show', [
            'article' => $article,
            'similar_content' => $this->getSimilarContent($article)
        ]);
    }

    private function getSimilarContent($article)
    {
        $similarContent = collect(SimilarContent::getSimilarContent($article))->take(5);

        return $similarContent->map(function (SimilarContentResult $item) {
                $similarItem = Article::find($item->targetId);
                $keywords = $similarItem->keywords ?: [];

                return [
                    'title' => $similarItem->title,
                    'slug' => $similarItem->slug,
                    'author' => $similarItem->author,
                    'published_at' => $similarItem->published_at,
                    'category' => $similarItem->category,
                    'similarity_score' => $item->similarityScore,
                    'content' => $similarItem->content,
                    'keywords' => implode(",", $keywords),
                ];
            });
    }

    private function getSearchResults(Request $request): Collection
    {
        $searchResults = $request->has('q') ? SimilarContent::search($request->get('q')) : [];

        $searchResults = collect($searchResults)->map(function (SimilarContentResult $result) {
            $article = Article::find($result->targetId);
            return $article ? array_merge($article->toArray(), [
                'similarity_score' => $result->similarityScore
            ]) : [];
        });

        return $searchResults;
    }
}
