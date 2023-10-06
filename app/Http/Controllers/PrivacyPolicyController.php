<?php

namespace App\Http\Controllers;

use Domain\Page\Models\Page;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;

class PrivacyPolicyController extends Controller
{
    public function index(): Response | ResponseFactory
    {
        
        $page = Page::whereSlug('privacy-policy')->firstOrFail();
        $page->load('meta', 'images')->getData();  

        return Inertia::render('PrivacyPolicy/Index', [
            'page' => $page,
        ]);
    }
}
