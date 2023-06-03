<?php

namespace App\Http\Controllers\Test;

use Domain\PageDescription\Actions\GetPageDescriptionByUrlAction;
use Domain\PageDescription\DataTransferObjects\PageDescriptionData;
use Domain\Search\DataTransferObjects\ParamsData;
use Domain\Room\ViewModels\RoomListViewModel;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;
use Parent\Controllers\Controller;

class RoomController extends Controller
{
    public function index(Request $request): Response | ResponseFactory
    {
        return Inertia::render('Room/Index', [
            'page_description' => PageDescriptionData::fromModel(GetPageDescriptionByUrlAction::run('/rooms')),
        ]);
    }
}
