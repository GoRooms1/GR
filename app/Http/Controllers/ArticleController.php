<?php

namespace App\Http\Controllers;

use Domain\Article\Models\Article;
use Domain\Article\ViewModels\ArticleListViewModel;
use Illuminate\View\View;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;

class ArticleController extends Controller
{
    public function index(): Response | ResponseFactory
    {
        return Inertia::render('Article/Index', new ArticleListViewModel());
    }

    public function show(Article $article): View
    {
        return view('web.articles.show', compact('article'));
    }
}
