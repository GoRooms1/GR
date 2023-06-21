<?php

namespace App\Http\Controllers;

use Domain\Search\DataTransferObjects\ParamsData;
use Domain\Object\ViewModels\ObjectsViewModel;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;

class HomeController extends Controller
{
    public function index(Request $request): Response | ResponseFactory
    {
        $params = ParamsData::fromRequest($request);
        if (!$params->filter) {
            $params->hotels->city = 'Москва и МО';         
        }

        return Inertia::render('Objects/Index',  new ObjectsViewModel($params, '/'));
    }
}
