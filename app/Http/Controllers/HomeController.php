<?php

namespace App\Http\Controllers;

use App\Actions\RatingCategory\GetRatingCategories;
use App\Models\Article;
use Domain\Address\Actions\GetAllMetrosByCityNameAction;
use Domain\Address\Actions\GetAllUniqueCitiesAction;
use Domain\Address\DataTransferObjects\CityData;
use Domain\Address\DataTransferObjects\SimpleMetroData;
use Domain\Filter\Actions\GetNumOfFilteredObjectsAction;
use Domain\Hotel\Models\Hotel;
use Domain\Page\DataTransferObjects\PageData;
use Domain\Page\Models\Page;
use Domain\PageDescription\Actions\GetPageDescriptionByUrlAction;
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
    public function index_(Request $request): View
    {
        $city = session('city', 'null');
        $auth = auth()->check() ? auth()->id() : 'user';
        $hotels = Cache::remember('hotels_city.'.$auth.'.'.$city, 60 * 60 * 24 * 12, function () use ($city) {
            return Hotel::popular()->whereHas('address', function (Builder $builder) use ($city) {
                $builder->where('city', $city);
            })->get();
        });
        $rooms = Cache::remember('rooms_city.'.$auth.'.'.$city, 60 * 60 * 24 * 12, function () use ($city) {
            return Room::with('hotel.ratings')->hot()->whereHas('hotel.address', function (Builder $builder) use ($city) {
                $builder->where('city', $city);
            })->get();
        });
        $articles = Cache::remember('articles_home', 60 * 60 * 24 * 12, function () {
            return Article::orderBy('created_at', 'DESC')->limit(4)->get();
        });
        $pages = Page::all()->keyBy('slug');
        $rating_categories = GetRatingCategories::run();

        return view('home', compact('hotels', 'rooms', 'articles', 'pages', 'rating_categories'));
    }

    public function index(Request $request): Response | ResponseFactory
    {        
        return Inertia::render('Home/Index', [
            'model' => [
                'page' => PageData::fromPageDescription(GetPageDescriptionByUrlAction::run($request->route()->uri))->toArray(),
            ],
            'cities' => CityData::collection(GetAllUniqueCitiesAction::run()),
            'metros' => SimpleMetroData::collection(GetAllMetrosByCityNameAction::run($request->all()['hotels']['city'] ?? null)),
            'total' => GetNumOfFilteredObjectsAction::run($request->all()),
        ]);
    }
}
