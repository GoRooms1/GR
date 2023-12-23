<?php

namespace Tests\Feature\Pages;

use Domain\Article\Models\Article;
use Domain\Page\Models\Page;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ArticlesPageTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndexPageOpenesSuccessfully(): void
    {
        /** @var Page $page */
        $page = Page::where('slug', 'blog')->with('image')->first();

        if (is_null($page))
            $page = Page::factory()->createOne([
                'slug' => 'blog',
            ]);
        
        $articles = Article::where('published', true)->orderBy('created_at', 'DESC')->paginate(config('pagination.articles_per_page'));

        $response = $this->get(route('articles.index'));

        $response->assertStatus(200);     
        $response->assertInertia(
            fn (Assert $model) => $model
                ->component('Article/Index')
                ->has('page.id')
                ->has('page.slug')
                ->has('page.title')
                ->has('articles.data', $articles->count())        
        );
    }

    public function testShowPageOpenesSuccessfully(): void    {
        $article = Article::where('published', true)->first();

        if (is_null($article))
        {
            $article = Article::factory()->createOne([]);
        }        
        
        $response = $this->get(route('articles.show', $article));

        $response->assertStatus(200);
       
        $response->assertInertia(
            fn (Assert $model) => $model
                ->component('Article/Show')              
                ->has('article.id')
                ->has('article.slug')
                ->etc()
        );
    }
}