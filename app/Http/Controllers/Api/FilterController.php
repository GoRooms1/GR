<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Json;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Hotel;
use App\Models\Metro;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    /**
     * Поиск города
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function cities(Request $request): JsonResponse
    {
        $request->validate([
            'search' => 'nullable|string',
        ]);
        $search = $request->get('search');
        if ($search) {
            $cities = Address::where('city', 'like', $search.'%')
              ->orderBy('city')
              ->pluck('city')
              ->unique();
        } else {
            $cities = Address::orderBy('city')
              ->pluck('city')
              ->unique();
        }

        return Json::good(['cities' => $cities]);
    }

    /**
     * Поиск округов в городе
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function city_area(Request $request): JsonResponse
    {
        $request->validate([
            'search' => 'nullable|string',
            'city' => 'required|string',
        ]);

        $search = $request->get('search', '');
        $search = $search ?? '';
        $city = $request->get('city');

        $city_areas = Address::whereCity($city)
          ->where('city_area', 'like', $search.'%')
          ->orderBy('city_area')
          ->pluck('city_area')
          ->unique();

        return Json::good(['city_areas' => $city_areas]);
    }

    /**
     * Поиск кол-ва окгругов в городе
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function count_city_area(Request $request): JsonResponse
    {
        $request->validate([
            'city' => 'required|string',
        ]);

        $city = $request->get('city');
        // @phpstan-ignore-next-line
        $count = Address::whereCity($city)
          ->whereNotNull('city_area')
          ->pluck('city_area')
          ->count();

        return Json::good(['count' => $count]);
    }

    /**
     * Поиск районов в городе и округе
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function district(Request $request): JsonResponse
    {
        $request->validate([
            'search' => 'nullable|string',
            'city' => 'required|string',
            'city_area' => 'nullable|string',
        ]);

        $search = $request->get('search', '');
        $search = $search ?? '';

        $city = $request->get('city');
        $city_area = $request->get('city_area', '');
        $city_area = $city_area ?? '';

        $districts = Address::query();
        $districts = $districts->where('city', $city);
        if ($city_area !== '') {
            $districts = $districts->where('city_area', $city_area);
        }
        $districts = $districts->where('city_district', 'like', $search.'%')
          ->orderBy('city_district')
          ->pluck('city_district')
          ->unique();

        return Json::good(['districts' => $districts]);
    }

    /**
     * Поиск метро в городе округе районе
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function metro(Request $request): JsonResponse
    {
        $request->validate([
            'search' => 'nullable|string',
            'city' => 'required|string',
            'city_area' => 'nullable|string',
            'district' => 'nullable|string',
        ]);

        $hotels_id = Address::query();
        if ($city = $request->get('city')) {
            $hotels_id = $hotels_id->whereCity($city);
        }

        if ($city_area = $request->get('city_area')) {
            $hotels_id = $hotels_id->where('city_area', $city_area);
        }

        if ($district = $request->get('district')) {
            $hotels_id = $hotels_id->where('city_district', $district);
        }

        $hotels_id = $hotels_id->pluck('hotel_id')->unique();

        $metros = Metro::query()->whereIn('hotel_id', $hotels_id);
        if ($search = $request->get('search')) {
            $metros = $metros->where('name', 'like', $search.'%');
        }
        $metros = $metros->orderBy('name')->pluck('name')
          ->unique();

        return Json::good(['metros' => $metros]);
    }

    public function all(Request $request): JsonResponse
    {
        $q = $request->get('q');

        $metros = new Collection();
        $hotels = Hotel::query()->without([
            'rooms',
            'attrs',
            'metros',
            'image',
            'images',
            'type',
        ]);
        $city = Address::query();
        $area = Address::query();
        $district = Address::query();
        $street = Address::query();
        $count = 0;

        if ($q) {
            $hotelM = Hotel::query();

            $hotelM = $hotelM->whereHas('metros', function ($q_metros) use ($q) {
                $q_metros->where('name', 'like', '%'.$q.'%');
            });

            $hotelM->each(function ($item) use ($metros, $q) {
                $m = $item->metros()->where('name', 'like', '%'.$q.'%')->get();
                $m->map(function ($m_item) use ($item) {
                    $m_item->address = $item->address;
                });
                $metros = $metros->add($m);
            });
            $metros = $metros->flatten(1);

            $metros = $metros->unique(function ($item) {
                return $item['address']['city'].$item['name'];
            })->take(4);

            $metros = $metros->values();

            $metros = $metros->all();
            // @phpstan-ignore-next-line
            $hotels = $hotels->where('name', 'like', '%'.$q.'%')
              ->get()
              ->take(4);

            $street = $street->where('street', 'like', '%'.$q.'%')
              ->get()
              ->unique('street')
              ->take(4);

            $city = $city->where('city', 'like', '%'.$q.'%')
              ->get()
              ->unique('city')
              ->take(4);

            $area = $area->where('city_area', 'like', '%'.$q.'%')
              ->get()
              ->unique('area')
              ->take(4);

            $district = $district->where('city_district', 'like', '%'.$q.'%')
              ->get()
              ->unique('city_district')
              ->take(4);

            $count += count($hotels) +
              count($metros) +
              count($street) +
              count($city) +
              count($area) +
              count($district);

            $streetTemp = new Collection();
            foreach ($street as $item) {
                // @phpstan-ignore-next-line
                $streetTemp->add([
                    'name' => $item->street,
                    'city' => $item->city,
                    'area' => $item->city_area,
                    'district' => $item->city_district,
                    'id' => $item->id,
                ]);
            }
            $street = $streetTemp;

            $cityTemp = new Collection();
            foreach ($city as $item) {
                // @phpstan-ignore-next-line
                $cityTemp->add([
                    'name' => $item->city,
                    'id' => $item->id,
                ]);
            }
            $city = $cityTemp;

            $districtTemp = new Collection();
            foreach ($district as $item) {
                // @phpstan-ignore-next-line
                $districtTemp->add([
                    'name' => $item->city_district,
                    'city' => $item->city,
                    'area' => $item->city_area,
                    'id' => $item->id,
                ]);
            }
            $district = $districtTemp;

            $areaTemp = new Collection();
            foreach ($area as $item) {
                // @phpstan-ignore-next-line
                $areaTemp->add([
                    'name' => $item->city_area,
                    'city' => $item->city,
                    'id' => $item->id,
                ]);
            }
            $area = $areaTemp;
        }

        return Json::good([
            'hotels' => $hotels,
            'metros' => $metros,
            'street' => $street,
            'district' => $district,
            'area' => $area,
            'city' => $city,
            'count' => $count,
        ]);
    }
}
