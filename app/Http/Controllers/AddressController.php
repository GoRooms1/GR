<?php

namespace App\Http\Controllers;

use Domain\Search\DataTransferObjects\ParamsData;
use Domain\Hotel\ViewModels\HotelListViewModel;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;
use Str;
use Support\DataProcessing\Traits\UrlDecodeFilter;

class AddressController extends Controller
{
    use UrlDecodeFilter;

    public function address(Request $request): Response | ResponseFactory
    {
        $params = ParamsData::fromRequest($request);
        if ($request->path() !== 'address') {
            $params->hotels = $this->decodeUrl($request->url());
        }

        return Inertia::render('Hotel/Index', new HotelListViewModel($params, Str::start($request->path(), '/')));
    }
}
