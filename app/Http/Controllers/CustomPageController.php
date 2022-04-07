<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Database\Query\Builder;

class CustomPageController extends Controller
{

  public function jacuzzi(Request $request)
  {
    $attr = Attribute::forRooms()->where('name', 'Джакузи')->first();
    if ($attr) {
      $rooms = Room::whereHas('attrs', static function ($q) use ($attr) {
        $q->where('id', $attr->id);
      })->paginate(16);
      $title = 'Номера отелей с Джакузи';
      $hotels = null;
//      dd($request->has('api'));
      if ($request->has('api')) {
        return view('web.search_', compact('rooms', 'hotels'));
      }
      return view('custom.jacuzzi', compact('rooms', 'hotels', 'title'));

    }

    abort(404);

  }
}