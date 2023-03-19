<?php

namespace App\Http\Controllers;

use Domain\Filter\DataTransferObjects\ParamsData;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function filter(Request $request)
    {
        $params = ParamsData::fromRequest($request);
        if ($params->isRoomsFilter == true) {
            return redirect()->route('rooms.index', $request->all());
        } else {
            return redirect()->route('hotels.index', $request->all());
        }
    }
}
