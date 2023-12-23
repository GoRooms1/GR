<?php

namespace Tests\Feature\Pages;

use Domain\Page\Models\Page;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class PrivacyPolicyPageTest extends TestCase
{
    use DatabaseTransactions;

    public function testPageOpenesSuccessfully(): void
    {
        /** @var Page $page */
        $page = Page::where('slug', 'privacy-policy')->with('image')->first();

        if (is_null($page))
            $page = Page::factory()->createOne([
                'slug' => 'privacy-policy',
            ]);

        $response = $this->get(route('privacy-policy.index'));

        $response->assertStatus(200);
        $response->assertInertia(
            fn (Assert $model) => $model
                ->component('PrivacyPolicy/Index')
                ->has('page.id')
                ->has('page.slug')
                ->has('page.title')             
        );
    }
}