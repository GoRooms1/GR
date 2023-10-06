<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Instruction;
use Domain\Page\Models\Page;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;

class InstructionController extends Controller
{
    public function index(): Response | ResponseFactory
    {
        $instructions = Instruction::all();
        $page = Page::whereSlug('instructions')->firstOrFail();

        return Inertia::render('Instruction/Index', [
            'instructions' => $instructions,
            'page' => $page->load('meta', 'images')->getData(),
        ]);
    }
}
