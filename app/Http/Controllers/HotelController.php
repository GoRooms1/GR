<?php

namespace App\Http\Controllers;

use Domain\Search\DataTransferObjects\ParamsData;
use Domain\Hotel\Models\Hotel;
use Domain\Hotel\ViewModels\HotelListViewModel;
use Domain\Hotel\ViewModels\HotelViewModel;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;

class HotelController extends Controller
{   
    public function index(Request $request): Response | ResponseFactory
    {        
        $params = ParamsData::fromRequest($request);
        if (!$params->filter) {
            $params->hotels->city = 'Москва';            
        }

        return Inertia::render('Hotel/Index', new HotelListViewModel($params));
    }

    public function show(Hotel $hotel, Request $request): Response | ResponseFactory
    {
        return Inertia::render('Hotel/Show', new HotelViewModel($hotel, ParamsData::fromRequest($request)));
    }
}
