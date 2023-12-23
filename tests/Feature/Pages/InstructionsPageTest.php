<?php

namespace Tests\Feature\Pages;

use App\Models\Instruction;
use Domain\Page\Models\Page;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class InstructionsPageTest extends TestCase
{
    use DatabaseTransactions;

    public function testPageOpenesSuccessfully(): void
    {
        /** @var Page $page */
        $page = Page::where('slug', 'instructions')->with('image')->first();

        if (is_null($page))
            $page = Page::factory()->createOne([
                'slug' => 'instructions',
            ]);

        $instructions = Instruction::all();

        $response = $this->get(route('instruction.index'));

        $response->assertStatus(200);
        $response->assertInertia(
            fn (Assert $model) => $model
                ->component('Instruction/Index')
                ->has('page.id')
                ->has('page.slug')
                ->has('page.title')
                ->has('instructions', $instructions->count())        
        );
    }
}