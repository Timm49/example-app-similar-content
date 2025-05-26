<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Inertia\Inertia;

class ArticleController extends Controller
{
    public function index()
    {
        return Inertia::render('Welcome', [
            'articles' => Article::latest()
                ->take(40)
                ->get()
        ]);
    }

    public function show(Article $article)
    {
        return Inertia::render('Articles/Show', [
            'article' => $article
        ]);
    }
}
