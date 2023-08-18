<?php

namespace App\Http\Controllers;

use Domain\Search\DataTransferObjects\ParamsData;
use Domain\Object\ViewModels\ObjectsViewModel;
use Domain\PageDescription\Models\PageDescription;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;
use Str;
use Support\Actions\DecodeRequestUrlAction;

class AddressController extends Controller
{   
    public function address(Request $request): Response | ResponseFactory
    {   
        $params = ParamsData::fromRequest($request);
        $path = Str::start($request->path(), '/');
        
        if (! PageDescription::where('url', $path)->exists()) {
            abort(404);
        }
        
        if (!$params->filter) {                       
            $params->hotels = DecodeRequestUrlAction::run($request);                      
        }

        return Inertia::render('Objects/Index', new ObjectsViewModel($params, $path));
    }
}
