<?php

namespace App\Http\Controllers;

use Domain\Article\Models\Article;
use Domain\Article\ViewModels\ArticleListViewModel;
use Domain\Article\ViewModels\ArticleViewModel;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;

class ArticleController extends Controller
{
    public function index(): Response | ResponseFactory
    {
        return Inertia::render('Article/Index', new ArticleListViewModel());
    }

    public function show(Article $article): Response | ResponseFactory
    {        
        if (!$article->published)
            abort(404);

        return Inertia::render('Article/Show', new ArticleViewModel($article));
    }
}
