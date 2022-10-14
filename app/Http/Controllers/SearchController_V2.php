<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\HotelType;
use App\Models\PageDescription;
use App\Traits\Filter;
use App\Traits\UrlDecodeFilter;
use Illuminate\Http\Request;

class SearchController_V2 extends Controller
{
    use Filter;
    use UrlDecodeFilter;

    public function index(Request $request)
    {
        $search = $request->get('query');
        $attributes = $request->get('attributes', ['hotel' => [], 'room' => []]);
        $city = $request->get('city');
        $city_area = $request->get('city_area');
        $district = $request->get('district');
        $hotel_type = $request->get('hotel_type');
        $metro = $request->get('metro');
        $cost = $request->get('cost');
        $search_price = $request->get('search-price');
        $hot = $request->boolean('hot');
        $moderate = $request->boolean('moderate', false);
        $no_city = $request->boolean('no_city', false);

        $data = $this->filter($search,
            $attributes,
            $city,
            $city_area,
            $district,
            $hotel_type,
            $metro,
            $hot,
            $search_price,
            $cost,
            false,
            false,
            $moderate,
            $no_city
        );

        $hotels = $data->hotels;
        $rooms = $data->rooms;

        if ($api = $request->boolean('api')) {
            return view('web.search_', compact('rooms', 'hotels', 'moderate'));
        }

        $count = 0;
        if ($rooms === null) {
            $count = $hotels->total();
        } else {
            $count = $rooms->total();
        }

        if ($data->united_hotels_bool && $count > 0) {
            $key = $data->united_cities->search($city);
            $data->united_cities = $data->united_cities->except($key);
            $data->united_cities->prepend($city);
            $data->united_cities = $data->united_cities->toArray();
            $city = $data->united_cities;
        }

        $pageDescription = $this->seo(
            $city,
            $district,
            $city_area,
            null,
            $metro,
            $attributes,
            $rooms !== null,
            null,
            $count
        );

        if ($moderate) {
            $pageDescription->title = 'На модерации'."<span class=\"count\">($count)</span>";
        }

        return view('search.index', compact(
            'rooms',
            'hotels',
            'pageDescription',
            'moderate'
        ));
    }

    public function map(Request $request)
    {
        $search = $request->get('query');
        $attributes = $request->get('attributes', ['hotel' => [], 'room' => []]);
        $city = $request->get('city', 'Москва');
        $city_area = $request->get('city_area');
        $district = $request->get('district');
        $hotel_type = $request->get('hotel_type');
        $metro = $request->get('metro');
        $cost = $request->get('cost');
        $search_price = $request->get('search-price');
        $hot = $request->boolean('hot');
        $moderate = $request->boolean('moderate', false);
        $data = $this->filter($search,
            $attributes,
            $city,
            $city_area,
            $district,
            $hotel_type,
            $metro,
            $hot,
            $search_price,
            $cost,
            true,
            true,
            $moderate,
            false
        );
        $hotels = $data->hotels;
        $hotels_popular = $data->hotels_popular;
        $count = $hotels->count();

        if ($data->united_hotels_bool && $count > 0) {
            $key = $data->united_cities->search($city);
            $data->united_cities = $data->united_cities->except($key);
            $data->united_cities->prepend($city);
            $data->united_cities = $data->united_cities->toArray();
            $city = $data->united_cities;
        }

        $pageDescription = $this->seo(
            $city,
            $district,
            $city_area,
            null,
            $metro,
            $attributes,
            false,
            null,
            $count
        );

        if ($request->boolean('moderate')) {
            $title = 'На модерации'."<span class=\"count\">($count)</span>";
            $pageDescription->title = 'На модерации'."<span class=\"count\">($count)</span>";
        }

        return view('search.map', compact('hotels', 'hotels_popular', 'pageDescription'));
    }

    public function address(Request $request)
    {
        $url = $request->url();
        $path = $request->getPathInfo();
        if (! PageDescription::where('url', $path)->exists()) {
            abort(404);
        }

        $data = $this->decodeUrl($url);

        $city = $data['city'];
        $metro = $data['metro'];
        $area = $data['area'];
        $district = $data['district'];
        $street = $data['street'];
        $search_price = null;
        $cost = null;
        $attributes = ['hotel' => [], 'room' => []];
        $hotel_type = null;
        $search = null;

        $dataCollectionDB = $this->filter($search,
            $attributes,
            $city,
            $area,
            $district,
            $hotel_type,
            $metro,
            false,
            $search_price,
            $cost,
            false,
            false,
            false,
            false
        );

        $hotels = $dataCollectionDB->hotels;
        $rooms = $dataCollectionDB->rooms;
        $count = 0;
        if ($rooms === null) {
            $count = $hotels->total();
        } else {
            $count = $rooms->total();
        }
        if ($api = $request->boolean('api')) {
            return view('web.search_', compact('rooms', 'hotels'));
        }

//    $pageDescription = $this->seo(
//      $city,
//      $district,
//      $area,
//      $street,
//      $metro,
//      $attributes,
//      $rooms !== null,
//      null,
//      $count
//    );

        // pageDesription генерируется в ViewProvider
        $slugs = [
            'city' => $city,
            'area' => $area,
            'district' => $district,
            'street' => $street,
            'metro' => $metro,
        ];

        $title = 'Отели города ';
        if (isset($slugs['city'])) {
            $title .= $slugs['city']
              .(isset($slugs['area']) ? ', '.$slugs['area'].' округ ' : '')
              .(isset($slugs['district']) ? ', '.$slugs['district'].' район ' : '')
              .(isset($slugs['street']) ? ', ул. '.$slugs['street'] : '')
              .(isset($slugs['metro']) ? ', метро "'.$slugs['metro'].'"' : '');
        }

        return view('search.index', compact(
            'rooms',
            'hotels',
            'title',
        ));
    }

    private function seo($city, $district, $area, $street, $metro, $attr, $is_room, $hotel_type, $count): object
    {
        /* START SEO */

        if (! is_array($city)) {
            $city = [$city];
        }
        $countCities = count($city);

        if ($countCities === 2) {
            $city = implode(' и ', $city);
            $titleCity = 'городах';
        } elseif ($countCities === 1) {
            $city = implode('', $city);
            $titleCity = 'городе';
        } else {
            $city = implode(', ', $city);
            $titleCity = 'городах';
        }

        //pageAbout
        $pageDescription = new class
        {
        };

        // Удобства в виде человекочитаемого списка
        $attr = array_merge(@$attr['hotel'] ?: [], @$attr['room'] ?: []);

        $attr = Attribute::whereIn('id', $attr)->pluck('name')->toArray();

//    $pageDescription->h1 = ", " . implode(", ", $attr);

        $attr = empty($attr) ? null : implode(', ', $attr);

        // Переменная для передачи в представление
        $slugs = [
            'city' => $city,
            'area' => $area,
            'district' => $district,
            'street' => $street,
            'metro' => $metro,
        ];

        if ((! empty($slugs['city'])) && (! empty($slugs['area'])) && (empty($slugs['district'])) && (empty($slugs['street'])) && (empty($slugs['metro']))) {
            if (! is_null($attr)) {
                $pageDescription->title = 'Отели в '.$titleCity.' "'.$slugs['city'].'",в "'.$slugs['area'].'" с выбранными условиями '.$attr;
                $pageDescription->meta_description = 'Ищете отель? Бронируйте гостиничные номера на час (сутки) с '.$attr.' в "'.$slugs['area'].'" Москвы ▶Описание номеров с фото  ▶ Звоните!';
            } else {
                $pageDescription->title = 'Отели в '.$titleCity.' "'.$slugs['city'].'",в "'.$slugs['area'].'"';
                $pageDescription->meta_description = 'Ищете отель? Бронируйте гостиничные номера на час (сутки) с '.$attr.' в "'.$slugs['area'].'" Москвы ▶Описание номеров с фото  ▶ Звоните!';
            }
        }

        if (! empty($slugs['street'])) {
            if (! empty($slugs['metro'])) {
                if ($attr) {
                    // Улица + метро + страница фильтрации по удобству
                    $pageDescription->title = 'Отели в '.$titleCity.' "'.$slugs['city'].'", около метро "'.$slugs['metro'].'" на улице "'.$slugs['street'].'" с выбранными условиями '.$attr;
                    //$pageDescription->title = 'Выгодные цены на отели с '.$attr.' на "'.$slugs['street'].'" рядом с метро "'.$slugs['metro'].'"';
                    $pageDescription->meta_description = 'Выбирайте и бронируйте почасовую гостиницу с '.$attr.' на "'.$slugs['street'].'" рядом с метро "'.$slugs['metro'].'" ▶ Актуальные цены ▶Обслуживание 24/7  ▶ Звоните!';
                } else {
                    // метро + улица
                    $pageDescription->title = 'Отели в '.$titleCity.' "'.$slugs['city'].'",около метро "'.$slugs['metro'].'" на улице "'.$slugs['street'].'" ';
                    // $pageDescription->title = 'Бронь отелей на "'.$slugs['street'].'" рядом с метро "'.$slugs['metro'].'" онлайн';
                    $pageDescription->meta_description = 'Компания Gorooms предлагает отели рядом с метро "'.$slugs['metro'].'" по улице "'.$slugs['street'].'" в Москве ▶Описание номеров с фото ▶ Доступные цены ▶ Бронируйте уже сейчас!';
                }
            } else {
                if ($attr) {
                    // Улица + страница фильтрации по удобству
                    $pageDescription->title = 'Гостницы с '.$attr.' на "'.$slugs['street'].'" улице - бронь онлайн';
                    $pageDescription->meta_description = 'Ищете отель? Бронируйте гостиничные номера на час (сутки) с '.$attr.' на "'.$slugs['street'].'" улице  Москвы ▶Свободные номера с актуальными ценами ▶ Звоните!';
                } else {
                    // Улицы
                    $pageDescription->title = 'Бронь отелей на "'.$slugs['street'].'" улице Москвы недорого';
                    $pageDescription->meta_description = 'Выбирайте и бронируйте гостиницу с номерами на час (сутки) на "'.$slugs['street'].'" улице в Москве ▶Описание номеров с фото и контактами ▶ Доступные цены ▶ Звоните!';
                }
            }
        } elseif (! empty($slugs['district'])) {
            if (! empty($slugs['metro'])) {
                if ($attr) {
                    // Район + метро + страница фильтрации по удобству
                    $pageDescription->title = 'Отели в '.$titleCity.' "'.$slugs['city'].'",в "'.$slugs['area'].'" в районе "'.$slugs['district'].'" около метро  "'.$slugs['metro'].'" с выбранными условиями '.$attr.'';
                    //  $pageDescription->title = 'Отели с '.$attr.' в "'.$slugs['district'].'" районе рядом с м. "'.$slugs['metro'].'" - бронь онлайн';
                    $pageDescription->meta_description = 'Компания Gorooms предлагает отели с '.$attr.' в "'.$slugs['district'].'" районе рядом с м. "'.$slugs['metro'].'" Москвы ▶Просторные номера▶ Доступные цены ▶ Бронируйте уже сейчас!';
                } else {
                    // Метро+район
                    $pageDescription->title = 'Отели в '.$titleCity.' "'.$slugs['city'].'",в "'.$slugs['area'].'" в районе "'.$slugs['district'].'" около метро  "'.$slugs['metro'].'"';
                    // $pageDescription->title = 'Отели у метро "'.$slugs['metro'].'" в "'.$slugs['district'].'" районе Москвы -бронь, цены';
                    $pageDescription->meta_description = 'Ищете отель? Бронируйте гостиницу с почасовыми номерами рядом с метро "'.$slugs['metro'].'" в "'.$slugs['district'].'" районе Москвы ▶Описание номеров с фото  ▶ Звоните!';
                }
            } else {
                if ($attr) {
                    // Район + страница фильтрации по удобству
                    $pageDescription->title = 'Отели в '.$titleCity.' "'.$slugs['city'].'", в районе "'.$slugs['district'].'" с выбранными условиями '.$attr.'';
                    // $pageDescription->title = 'Отели в городе "'.$slugs['district'].'" с выбранными условиями '.$attr.'';
                    //$pageDescription->title = '111Гостиницы с '.$attr.' в "'.$slugs['district'].'" - бронь онлайн';
                    $pageDescription->meta_description = 'Компания Gorooms предлагает отели с "'.$attr.'" в "'.$slugs['district'].'" районе Москвы ▶Просторные номера▶ Доступные цены ▶ Бронируйте уже сейчас!';
                } else {
                    // Районы
                    $pageDescription->title = 'Отели в городе"'.$slugs['city'].'", в районе "'.$slugs['district'].'" ';
                    // $pageDescription->title = 'Гостиницы в "'.$slugs['district'].'" районе  Москвы - цены, фото, бронирование';
                    $pageDescription->meta_description = 'Ищете отель? С Gorooms Вы сможете быстро подобрать отель на час (сутки) в "'.$slugs['district'].'" районе Москвы ▶ Подробное описание номеров с фото ▶ Бронируйте уже сейчас!';
                }
            }
        } elseif (! empty($slugs['metro'])) {
            if (! empty($slugs['area'])) {
                if ($attr) {
                    // Округ + метро + страница фильтрации по удобству
                    $pageDescription->title = 'Отели в '.$titleCity.' "'.$slugs['city'].'",в "'.$slugs['area'].'" около метро  "'.$slugs['metro'].'"с выбранными условиями '.$attr;
                    //  $pageDescription->title = 'Бронь отелей с '.$attr.' в "'.$slugs['area'].'" Москвы рядом с метро "'.$slugs['metro'].'" ';
                    $pageDescription->meta_description = 'Забронируйте гостиницу на час с '.$attr.' в "'.$slugs['area'].'" Москвы рядом с метро "'.$slugs['metro'].'"▶ Свободные номера и актуальные цены ▶ Заказывайте уже сейчас!';
                } else {
                    // метро + округ
                    $pageDescription->title = 'Отели в '.$titleCity.' "'.$slugs['city'].'",в "'.$slugs['area'].'" около метро  "'.$slugs['metro'].'"';
                    //  $pageDescription->title = 'Отели рядом с метро "'.$slugs['metro'].'" в "'.$slugs['area'].'" Москвы - бронь онлайн';
                    $pageDescription->meta_description = 'Ищете отель? Бронируйте гостиницу с почасовыми номерами рядом с метро "'.$slugs['metro'].'" в "'.$slugs['area'].'" районе Москвы ▶Описание номеров с фото  ▶ Звоните!';
                }
            } else {
                if ($attr) {
                    // Метро + страница фильтрации по удобству
                    $pageDescription->title = 'Отели в '.$titleCity.' "'.$slugs['city'].'",в "'.$slugs['area'].'" около метро  "'.$slugs['metro'].'"с выбранными условиями '.$attr;
                    //$pageDescription->title = 'Отели с '.$attr.' рядом с "'.$slugs['metro'].'" метро - бронь, цены';
                    $pageDescription->meta_description = 'Бронируйте уютные гостиничные номера с '.$attr.' рядом с метро "'.$slugs['metro'].'" по приятным ценам в Москве ▶Описание номеров с фото  ▶ Звоните!';
                } else {
                    // Станции метро
                    $pageDescription->title = 'Отели в '.$titleCity.' "'.$slugs['city'].'",в "'.$slugs['area'].'" около метро  "'.$slugs['metro'].'"';
                    // $pageDescription->title = 'Отели у метро "'.$slugs['metro'].'"  - выгодные цены в Москве';
                    $pageDescription->meta_description = 'Бронирование отелей рядом с метро "'.$slugs['metro'].'" по минимальным ценам  ▶ Подробное описание номеров с фото и контактами ▶ Уютные номера с удобствами  ▶ Звоните!';
                }
            }
        } elseif ($attr) {
            if (! empty($slugs['area'])) {
                // Округ + страница фильтрации по удобству
                $pageDescription->title = 'Отели в '.$titleCity.' "'.$slugs['city'].'",в "'.$slugs['area'].'" с выбранными условиями '.$attr;
                $pageDescription->meta_description = 'Ищете отель? Бронируйте гостиничные номера на час (сутки) с '.$attr.' в "'.$slugs['area'].'" Москвы ▶Описание номеров с фото  ▶ Звоните!';
            } else {
                // Просто страница фильтрации по удобству (все варианты удобств)
                $pageDescription->title = 'Отели в Москве со всеми удобствами в номере - бронь номеров онлайн';
                $pageDescription->meta_description = 'Выбирайте и бронируйте комфортабельные гостиничные номера на час (сутки) со всеми удобствами в компании Gorooms ▶Выгодные цены ▶Качественный сервис ▶ Звоните!';
            }
        }

        $title = '';
        if (isset($slugs['city'])) {
            $title = ($is_room ? 'Номера города ' : 'Отели города ')
              .$slugs['city']
              .(isset($slugs['area']) ? ', '.$slugs['area'].' округ ' : '')
              .(isset($slugs['district']) ? ', '.$slugs['district'].' район ' : '')
              .(isset($slugs['street']) ? ', ул. '.$slugs['street'] : '')
              .(isset($slugs['metro']) ? ', метро "'.$slugs['metro'].'"' : '');
        }
        if (! $title) {
            $title = 'Результаты поиска';
        }
        $title .= "<span class=\"count\">($count)</span>";
        $pageDescription->title = $title;

        if (! $is_room) {
            if (is_null($hotel_type)) {
                $desc_city_name = 'Отели';
            } else {
                $desc_city_name = HotelType::find($hotel_type)->name;
            }
        } else {
            $desc_city_name = 'Номера';
        }

        if ($city) {
            $desc_city = $desc_city_name.' в '.$titleCity.' '.$city;
        } else {
            $desc_city = '';
        }
        if ($area) {
            $desc_area = ' в '.$area;
        } else {
            $desc_area = '';
        }
        if ($district) {
            $desc_district = ' в районе '.$district;
        } else {
            $desc_district = '';
        }
        if ($street) {
            $desc_street = ' на улице '.$street;
        } else {
            $desc_street = '';
        }
        if ($metro) {
            $desc_metro = ' около метро '.$metro;
        } else {
            $desc_metro = '';
        }
        if ($attr) {
            $desc_attr = ' с выбранными условиями '.$attr;
        } else {
            $desc_attr = '';
        }
        $pageDescription->title = $desc_city.$desc_area.$desc_district.$desc_street.$desc_metro.$desc_attr;

        return $pageDescription;
    }
}
