<?php

namespace App\Http\Controllers;

use App\Traits\Breadcrumbs;
use Domain\Address\Actions\GetAllMetrosByCityNameAction;
use Domain\Address\Actions\GetAllUniqueCitiesAction;
use Domain\Address\DataTransferObjects\CityData;
use Domain\Address\DataTransferObjects\SimpleMetroData;
use Domain\Filter\Actions\GetNumOfFilteredObjectsAction;
use Domain\Hotel\Actions\FilterHotelsAction;
use Domain\Hotel\DataTransferObjects\HotelData;
use Domain\Hotel\Models\Hotel;
use Domain\Page\DataTransferObjects\PageData;
use Domain\PageDescription\Actions\GetPageDescriptionByUrlAction;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;

class HotelController extends Controller
{
    use Breadcrumbs;

    public function index(Request $request): Response | ResponseFactory
    {        
        return Inertia::render('Hotel/Index', [
            'model' => [
                'page' => PageData::fromPageDescription(GetPageDescriptionByUrlAction::run('/hotels'))->toArray(),
            ],
            'hotels' => HotelData::Collection(FilterHotelsAction::run(optional($request->all())['hotels'] ?? [], true)),
            'cities' => CityData::collection(GetAllUniqueCitiesAction::run()),
            'metros' => SimpleMetroData::collection(GetAllMetrosByCityNameAction::run($request->all()['hotels']['city'] ?? null)),
            'total' => GetNumOfFilteredObjectsAction::run($request->all()),                                   
        ]);
    }
    
    //Depricated
    public function index_(Request $request): View
    {
        $Breadcrumbs_din = $this->get_bread();

        $hotels = Hotel::paginate(18);

        return view('hotel.index', compact('hotels', 'request', 'Breadcrumbs_din'));
    }

    public function show_(Hotel $hotel, Request $request): View
    {
        $Breadcrumbs_din = $this->get_bread();

        $pageAbout = $hotel->meta ?? new class
        {
            public $title = null;

            public $meta_description = null;
        };

        $pageAbout->title ??= sprintf('Отель "%s" - бронь номера на час ▶Gorooms', $hotel->name);

        $pageAbout->meta_description ??= sprintf('Забронируйте номер в отеле на час (сутки) "%s" онлайн в компании Gorooms ▶ Без комиссий и посредников▶ Качественное обслуживание ▶ Низкие цены ▶ Звоните!', $hotel->name);

        return view('hotel.show', compact('hotel', 'request', 'pageAbout', 'Breadcrumbs_din'));
    }
}
