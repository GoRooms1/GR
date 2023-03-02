<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function filter(Request $request)
    {        
        $isRoomsFilter = $request->all()['isRoomsFilter'] ?? 'false';       
        if ($isRoomsFilter == 'true') {
            return redirect()->route('rooms.index', $request->all());
        }
        else {
            return redirect()->route('hotels.index', $request->all());
        }       
    }
}
