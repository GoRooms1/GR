<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        $articles = Article::orderBy('created_at', 'DESC')->paginate(10);

        return view('web.articles.index', compact('articles'));
    }

    public function show(Article $article): View
    {
        return view('web.articles.show', compact('article'));
    }
}
