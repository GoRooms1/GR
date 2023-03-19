<?php

namespace App\Http\Controllers;

use App\Traits\Breadcrumbs;
use Domain\Filter\DataTransferObjects\ParamsData;
use Domain\Hotel\Models\Hotel;
use Domain\Hotel\ViewModels\HotelListViewModel;
use Domain\Hotel\ViewModels\HotelViewModel;
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
        return Inertia::render('Hotel/Index', new HotelListViewModel(ParamsData::fromRequest($request)));
    }

    public function show(Hotel $hotel): Response | ResponseFactory
    {       
        return Inertia::render('Hotel/Show', new HotelViewModel($hotel));
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
