<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use Domain\Article\Models\Article;
use Domain\Image\Actions\UploadImageAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $articles = Article::all();

        return view('admin.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ArticleRequest  $request
     * @return RedirectResponse
     */
    public function store(ArticleRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated = Article::getFillableData($validated);
        $validated['published'] = $request->boolean('published', false);
        $article = Article::create($validated);
        $article->user()->associate(Auth::user()->id);
        $article->save();

        if ($request->file('image')) {
            $article->clearMediaCollection('images');
            $article->addMediaFromRequest('image')
                ->toMediaCollection('images');
        }        

        return redirect()->route('admin.articles.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return View
     */
    public function edit(Article $article): View
    {
        return view('admin.articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ArticleRequest  $request
     * @param  \App\Models\Article  $article
     * @return RedirectResponse
     */
    public function update(ArticleRequest $request, Article $article): RedirectResponse
    {
        $validated = $request->validated();       
        $validated = Article::getFillableData($validated);
        $validated['published'] = $request->boolean('published', false);
        $article->update($validated);

        if ($request->file('image')) {
            $article->clearMediaCollection('images');
            $article->addMediaFromRequest('image')
                ->toMediaCollection('images');
        }

        return redirect()->route('admin.articles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return RedirectResponse
     */
    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();

        return redirect()->route('admin.articles.index');
    }
}
