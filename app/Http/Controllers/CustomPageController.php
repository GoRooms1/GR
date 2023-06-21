<?php

namespace App\Http\Controllers;

use Domain\Attribute\Model\Attribute;
use Domain\Object\ViewModels\ObjectsViewModel;
use Domain\Search\DataTransferObjects\ParamsData;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;

class CustomPageController extends Controller
{ 
    public function jacuzzi(Request $request): Response | ResponseFactory
    {        
        $paramsData = ParamsData::fromRequest($request);
        
        if (!$paramsData->filter) {
            $paramsData = ParamsData::getEmptyData();
            $paramsData->room_filter = true;
            $paramsData->hotels->city = 'Москва';
            $paramsData->rooms->attrs = [
                optional(Attribute::forRooms()->where('name', 'Джакузи')->first())->id ?? 0
            ];            
        }

        return Inertia::render('Objects/Index', new ObjectsViewModel($paramsData, '/jacuzzi'));
    }

    public function centre(Request $request): Response | ResponseFactory
    {        
        $paramsData = ParamsData::fromRequest($request);
        
        if (!$paramsData->filter) {
            $paramsData = ParamsData::getEmptyData();
            $paramsData->room_filter = false;
            $paramsData->hotels->city = 'Москва';
            $paramsData->hotels->area = 'Центральный';
        }               
        
        return Inertia::render('Objects/Index', new ObjectsViewModel($paramsData, '/centre'));
    }

    public function fiveMinut(Request $request): Response | ResponseFactory
    {        
        $paramsData = ParamsData::fromRequest($request);
        
        if (!$paramsData->filter) {
            $paramsData = ParamsData::getEmptyData();
            $paramsData->room_filter = false;
            $paramsData->hotels->city = 'Москва';
            $paramsData->hotels->attrs = [
                optional(Attribute::forHotels()->where('name', '5 минут до метро')->first())->id ?? 0
            ];
        }   
        
        return Inertia::render('Objects/Index', new ObjectsViewModel($paramsData, '/5minut'));
    }

    public function lowcost(Request $request): Response | ResponseFactory
    {        
        $paramsData = ParamsData::fromRequest($request);
        
        if (!$paramsData->filter) {
            $paramsData = ParamsData::getEmptyData();
            $paramsData->room_filter = true;
            $paramsData->hotels->city = 'Москва';
            $paramsData->rooms->low_cost = true;
        }        

        return Inertia::render('Objects/Index', new ObjectsViewModel($paramsData, '/lowcost'));
    }
}
