<?php

namespace App\Http\Controllers;

use Domain\Page\Models\Page;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;

class AboutController extends Controller
{
    public function index(): Response | ResponseFactory
    {        
        $page = Page::whereSlug('about')->firstOrFail();
        $page->load('meta', 'images')->getData();  

        return Inertia::render('About/Index', [
            'page' => $page,
        ]);
    }
}
