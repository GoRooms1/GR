<?php

namespace Tests\Feature;

use Domain\Page\Models\Page;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ContactPageTest extends TestCase
{
    use DatabaseTransactions;

    public function testPageOpenesSuccessfully(): void
    {
        /** @var Page $page */
        $page = Page::factory()->createOne([
            'slug' => 'contacts',
        ]);
        $response = $this->get(route('contact'));

        $response->assertStatus(200);
        $response->assertInertia(
            fn (Assert $content) => $content
                ->component('Content/Contact')
            ->has('model', fn (Assert $content) => $content
                ->where('page.id', $page->id)
                ->where('page.content', $page->content)
            )
        );
    }
}
