<?php

namespace App\Http\Controllers;

use Domain\Attribute\Model\Attribute;
use Domain\Hotel\ViewModels\HotelListViewModel;
use Domain\Room\ViewModels\RoomListViewModel;
use Domain\Search\DataTransferObjects\ParamsData;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;

class CustomPageController extends Controller
{ 
    public function jacuzzi(Request $request): Response | ResponseFactory
    {        
        $paramsData = ParamsData::getEmptyData();
        $paramsData->isRoomsFilter = true;
        $paramsData->hotels->city = 'Москва';
        $paramsData->rooms->attributes = [
            optional(Attribute::forRooms()->where('name', 'Джакузи')->first())->id ?? 0
        ];

        return Inertia::render('Room/Index', new RoomListViewModel($paramsData, '/jacuzzi'));
    }

    public function centre(Request $request): Response | ResponseFactory
    {        
        $paramsData = ParamsData::getEmptyData();
        $paramsData->isRoomsFilter = false;
        $paramsData->hotels->city = 'Москва';
        $paramsData->hotels->city_area = 'Центральный';       
        
        return Inertia::render('Hotel/Index', new HotelListViewModel($paramsData, '/centre'));
    }

    public function fiveMinut(Request $request): Response | ResponseFactory
    {        
        $paramsData = ParamsData::getEmptyData();
        $paramsData->isRoomsFilter = false;
        $paramsData->hotels->city = 'Москва';
        $paramsData->hotels->attributes = [
            optional(Attribute::forHotels()->where('name', '5 минут до метро')->first())->id ?? 0
        ];     
        
        return Inertia::render('Hotel/Index', new HotelListViewModel($paramsData, '/5minut'));
    }

    public function lowcost(Request $request): Response | ResponseFactory
    {        
        $paramsData = ParamsData::getEmptyData();
        $paramsData->isRoomsFilter = true;
        $paramsData->hotels->city = 'Москва';
        $paramsData->rooms->low_cost = true;

        return Inertia::render('Room/Index', new RoomListViewModel($paramsData, '/lowcost'));
    }
}
