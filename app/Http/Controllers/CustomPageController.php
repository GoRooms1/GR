<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Hotel;
use App\Models\Address;
use App\Models\CostType;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class CustomPageController extends Controller
{

  public function jacuzzi(Request $request)
  {
    $attr = Attribute::forRooms()->where('name', 'Джакузи')->first();
    if ($attr) {
      $rooms = Room::whereHas('attrs', static function ($q) use ($attr) {
        $q->where('id', $attr->id);
      });
      $rooms = $rooms->whereHas('hotel', function ($q_hotels) {
        $q_hotels->whereHas('address', function ($q_address) {
          $q_address->where('city', 'Москва');
        });
      });
      $rooms = $rooms->paginate(16);
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

  public function centre(Request $request)
  {
    $hotels = Hotel::whereHas('address', static function ($q) {
      $q->where('city', 'Москва')->where('city_area', 'Центральный');
    });
    $hotels = $hotels->paginate(16);
    $title = 'Отели в Центре Москвы';
    $rooms = null;
//      dd($request->has('api'));
    if ($request->has('api')) {
      return view('web.search_', compact('rooms', 'hotels'));
    }
    return view('custom.jacuzzi', compact('rooms', 'hotels', 'title'));
  }

  public function fiveMinut(Request $request)
  {
    $attr = Attribute::forHotels()->where('name', '5 минут до метро')->first();
    if ($attr) {
      $hotels = Hotel::whereHas('attrs', static function ($q) use ($attr) {
        $q->where('id', $attr->id);
      });
      $unitedCities = Address::where('city', 'Москва')->first();
      $unitedCities = $unitedCities->unitedCities();

      $hotels = $hotels->whereHas('address', function ($q) use ($unitedCities) {
        foreach ($unitedCities as $key => $unitedCity) {
          if ($key === 0) {
            $q->where('city', $unitedCity);
          } else {
            $q->orWhere('city', $unitedCity);
          }
        }
      });

      $hotels = $hotels->paginate(16);
      $title = 'Отели на час, всего в пяти минутах пешком от метро';
      $rooms = null;
      if ($request->has('api')) {
        return view('web.search_', compact('rooms', 'hotels'));
      }
      return view('custom.jacuzzi', compact('rooms', 'hotels', 'title'));
    }

    abort(404);
  }

  public function test(Request $request)
  {
    $rooms = Room::whereHas('hotel', static function ($q_hotels) {
      $q_hotels->whereHas('address', static function ($q) {
        $q->where('city', 'Москва');
      });
    });

    $rooms = $rooms->whereHas('costs', function ($q_costs) {
      $type_price = CostType::whereSlug('na-cas')->first();
      $q_costs->whereHas('period', function (Builder $q_period) use ($type_price) {
//      Ищем определённый тип периода в комнатах
        $q_period->where('cost_type_id', $type_price->id);
      });
      $q_costs->where('value', '<=', 700);
    });
    $rooms = $rooms->paginate(16);
    $title = 'Недороги отели и Гостиницы в Москве';
    $hotels = null;

    if ($request->has('api')) {
      return view('web.search_', compact('rooms', 'hotels'));
    }
    return view('custom.jacuzzi', compact('rooms', 'hotels', 'title'));
  }
}