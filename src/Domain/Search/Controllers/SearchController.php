<?php

namespace Domain\Search\Controllers;

use Domain\Object\ViewModels\ObjectsViewModel;
use Domain\Search\DataTransferObjects\ParamsData;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;
use Parent\Controllers\Controller;
use Str;

class SearchController extends Controller
{
    public function index(Request $request): Response | ResponseFactory
    {
        return Inertia::render('Objects/Index', new ObjectsViewModel(ParamsData::fromRequest($request), Str::start($request->path(), '/')));
    }
}
