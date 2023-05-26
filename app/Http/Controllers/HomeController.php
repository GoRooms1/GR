<?php

namespace App\Http\Controllers;

use App\Actions\RatingCategory\GetRatingCategories;
use App\Models\Article;
use Domain\Search\DataTransferObjects\ParamsData;
use Domain\Home\ViewModels\HomeViewModel;
use Domain\Hotel\Models\Hotel;
use Domain\Page\Models\Page;
use Domain\Room\Models\Room;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;

class HomeController extends Controller
{
    public function index(Request $request): Response | ResponseFactory
    {
        return Inertia::render('Home/Index', new HomeViewModel(ParamsData::fromRequest($request)));
    }
}
