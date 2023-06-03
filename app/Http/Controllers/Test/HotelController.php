<?php

namespace App\Http\Controllers\Test;

use Domain\Search\DataTransferObjects\ParamsData;
use Domain\Hotel\ViewModels\HotelListViewModel;
use Domain\PageDescription\Actions\GetPageDescriptionByUrlAction;
use Domain\PageDescription\DataTransferObjects\PageDescriptionData;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;
use Parent\Controllers\Controller;

class HotelController extends Controller
{   
    public function index(Request $request): Response | ResponseFactory
    {
        return Inertia::render('Hotel/Index', [
            'page_description' =>PageDescriptionData::fromModel(GetPageDescriptionByUrlAction::run('/hotels')),
        ]);
    }
}
