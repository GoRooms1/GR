<?php

namespace Domain\Search\Controllers;

use Domain\Search\ViewModels\SearchMapViewModel;
use Domain\Search\DataTransferObjects\ParamsData;
use Domain\Search\ViewModels\SearchViewModel;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;
use Parent\Controllers\Controller;

class SearchController extends Controller
{
    public function list(Request $request): Response | ResponseFactory
    {
        return Inertia::render('Search/Index', new SearchViewModel(ParamsData::fromRequest($request)));
    }

    public function map(Request $request): Response | ResponseFactory
    {
        return Inertia::render('SearchMap/Index', new SearchMapViewModel(ParamsData::fromRequest($request)));
    }    
}
