<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{

    public function show(Page $page): View
    {
        if (!isset($page->meta)) {
            $path = Request::capture()->path();
            $page = Page::where('slug', $path)->first();

        }

        $pageAbout = $page->meta;
        return view('web.pages.show', compact('page', 'pageAbout'));
    }
}
