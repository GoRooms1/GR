<?php

namespace Tests\Feature\Pages;

use Domain\Page\Models\Page;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class AboutPageTest extends TestCase
{
    use DatabaseTransactions;

    public function testPageOpenesSuccessfully(): void
    {
        /** @var Page $page */
        $page = Page::where('slug', 'about')->with('image')->first();

        if (is_null($page))
            $page = Page::factory()->createOne([
                'slug' => 'about',
            ]);

        $response = $this->get(route('about.index'));

        $response->assertStatus(200);
        $response->assertInertia(
            fn (Assert $model) => $model
                ->component('About/Index')
                ->has('page.id')
                ->has('page.slug')
                ->has('page.title')             
        );
    }
}