<?php

declare(strict_types=1);

namespace Domain\PageDescription\Actions;

use Domain\Attribute\Model\Attribute;
use Domain\Hotel\Models\HotelType;
use Domain\PageDescription\Models\PageDescription;
use Domain\Search\DataTransferObjects\ParamsData;
use Lorisleiva\Actions\Action;

/**
 * @method static PageDescription run(ParamsData $paramsData)
 */
final class GetPageDescriptionFromParamsData extends Action
{
    public function handle(ParamsData $paramsData): PageDescription
    {
        $pageDescription = $this->seo(
            $paramsData->hotels->city,
            $paramsData->hotels->district,
            $paramsData->hotels->area,
            null,
            $paramsData->hotels->metro,
            array_merge($paramsData->hotels->attrs, $paramsData->rooms->attrs),
            $paramsData->room_filter,
            $paramsData->hotels->type
        );

        return $pageDescription;
    }

    private function seo($city, $district, $area, $street, $metro, $attrs, $is_room, $hotel_type): PageDescription
    {
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

        $pageDescription = new PageDescription();

        $attributes = Attribute::whereIn('id', $attrs)->pluck('name')->toArray();
        $attributes = empty($attributes) ? null : implode(', ', $attributes);
       
        $slugs = [
            'city' => $city,
            'area' => $area,
            'district' => $district,
            'street' => $street,
            'metro' => $metro,
        ];

        if ((! empty($slugs['city'])) && (! empty($slugs['area'])) && (empty($slugs['district'])) && (empty($slugs['street'])) && (empty($slugs['metro']))) {
            if (! empty($attrs)) {
                $pageDescription->title = 'Отели в '.$titleCity.' "'.$slugs['city'].'",в "'.$slugs['area'].'" с выбранными условиями '.$attributes;
                $pageDescription->meta_description = 'Ищете отель? Бронируйте гостиничные номера на час (сутки) с '.$attributes.' в "'.$slugs['area'].'" Москвы ▶Описание номеров с фото  ▶ Звоните!';
            } else {
                $pageDescription->title = 'Отели в '.$titleCity.' "'.$slugs['city'].'",в "'.$slugs['area'].'"';
                $pageDescription->meta_description = 'Ищете отель? Бронируйте гостиничные номера на час (сутки) с '.$attributes.' в "'.$slugs['area'].'" Москвы ▶Описание номеров с фото  ▶ Звоните!';
            }
        }

        if (! empty($slugs['street'])) {
            if (! empty($slugs['metro'])) {
                if (! empty($attrs)) {
                    // Улица + метро + страница фильтрации по удобству
                    $pageDescription->title = 'Отели в '.$titleCity.' "'.$slugs['city'].'", около метро "'.$slugs['metro'].'" на улице "'.$slugs['street'].'" с выбранными условиями '.$attributes;                    
                    $pageDescription->meta_description = 'Выбирайте и бронируйте почасовую гостиницу с '.$attributes.' на "'.$slugs['street'].'" рядом с метро "'.$slugs['metro'].'" ▶ Актуальные цены ▶Обслуживание 24/7  ▶ Звоните!';
                } else {
                    // метро + улица
                    $pageDescription->title = 'Отели в '.$titleCity.' "'.$slugs['city'].'",около метро "'.$slugs['metro'].'" на улице "'.$slugs['street'].'" ';                    
                    $pageDescription->meta_description = 'Компания Gorooms предлагает отели рядом с метро "'.$slugs['metro'].'" по улице "'.$slugs['street'].'" в Москве ▶Описание номеров с фото ▶ Доступные цены ▶ Бронируйте уже сейчас!';
                }
            } else {
                if (! empty($attrs)) {
                    // Улица + страница фильтрации по удобству
                    $pageDescription->title = 'Гостницы с '.$attributes.' на "'.$slugs['street'].'" улице - бронь онлайн';
                    $pageDescription->meta_description = 'Ищете отель? Бронируйте гостиничные номера на час (сутки) с '.$attributes.' на "'.$slugs['street'].'" улице  Москвы ▶Свободные номера с актуальными ценами ▶ Звоните!';
                } else {
                    // Улицы
                    $pageDescription->title = 'Бронь отелей на "'.$slugs['street'].'" улице Москвы недорого';
                    $pageDescription->meta_description = 'Выбирайте и бронируйте гостиницу с номерами на час (сутки) на "'.$slugs['street'].'" улице в Москве ▶Описание номеров с фото и контактами ▶ Доступные цены ▶ Звоните!';
                }
            }
        } elseif (! empty($slugs['district'])) {
            if (! empty($slugs['metro'])) {
                if (! empty($attrs)) {
                    // Район + метро + страница фильтрации по удобству
                    $pageDescription->title = 'Отели в '.$titleCity.' "'.$slugs['city'].'",в "'.$slugs['area'].'" в районе "'.$slugs['district'].'" около метро  "'.$slugs['metro'].'" с выбранными условиями '.$attributes.'';
                    $pageDescription->meta_description = 'Компания Gorooms предлагает отели с '.$attributes.' в "'.$slugs['district'].'" районе рядом с м. "'.$slugs['metro'].'" Москвы ▶Просторные номера▶ Доступные цены ▶ Бронируйте уже сейчас!';
                } else {
                    // Метро+район
                    $pageDescription->title = 'Отели в '.$titleCity.' "'.$slugs['city'].'",в "'.$slugs['area'].'" в районе "'.$slugs['district'].'" около метро  "'.$slugs['metro'].'"';                    
                    $pageDescription->meta_description = 'Ищете отель? Бронируйте гостиницу с почасовыми номерами рядом с метро "'.$slugs['metro'].'" в "'.$slugs['district'].'" районе Москвы ▶Описание номеров с фото  ▶ Звоните!';
                }
            } else {
                if (! empty($attrs)) {
                    // Район + страница фильтрации по удобству
                    $pageDescription->title = 'Отели в '.$titleCity.' "'.$slugs['city'].'", в районе "'.$slugs['district'].'" с выбранными условиями '.$attributes.'';                    
                    $pageDescription->meta_description = 'Компания Gorooms предлагает отели с "'.$attributes.'" в "'.$slugs['district'].'" районе Москвы ▶Просторные номера▶ Доступные цены ▶ Бронируйте уже сейчас!';
                } else {
                    // Районы
                    $pageDescription->title = 'Отели в городе"'.$slugs['city'].'", в районе "'.$slugs['district'].'" ';                    
                    $pageDescription->meta_description = 'Ищете отель? С Gorooms Вы сможете быстро подобрать отель на час (сутки) в "'.$slugs['district'].'" районе Москвы ▶ Подробное описание номеров с фото ▶ Бронируйте уже сейчас!';
                }
            }
        } elseif (! empty($slugs['metro'])) {
            if (! empty($slugs['area'])) {
                if (! empty($attrs)) {
                    // Округ + метро + страница фильтрации по удобству
                    $pageDescription->title = 'Отели в '.$titleCity.' "'.$slugs['city'].'",в "'.$slugs['area'].'" около метро  "'.$slugs['metro'].'"с выбранными условиями '.$attributes;                    
                    $pageDescription->meta_description = 'Забронируйте гостиницу на час с '.$attributes.' в "'.$slugs['area'].'" Москвы рядом с метро "'.$slugs['metro'].'"▶ Свободные номера и актуальные цены ▶ Заказывайте уже сейчас!';
                } else {
                    // метро + округ
                    $pageDescription->title = 'Отели в '.$titleCity.' "'.$slugs['city'].'",в "'.$slugs['area'].'" около метро  "'.$slugs['metro'].'"';                    
                    $pageDescription->meta_description = 'Ищете отель? Бронируйте гостиницу с почасовыми номерами рядом с метро "'.$slugs['metro'].'" в "'.$slugs['area'].'" районе Москвы ▶Описание номеров с фото  ▶ Звоните!';
                }
            } else {
                if (! empty($attrs)) {
                    // Метро + страница фильтрации по удобству
                    $pageDescription->title = 'Отели в '.$titleCity.' "'.$slugs['city'].'",в "'.$slugs['area'].'" около метро  "'.$slugs['metro'].'"с выбранными условиями '.$attributes;                    
                    $pageDescription->meta_description = 'Бронируйте уютные гостиничные номера с '.$attributes.' рядом с метро "'.$slugs['metro'].'" по приятным ценам в Москве ▶Описание номеров с фото  ▶ Звоните!';
                } else {
                    // Станции метро
                    $pageDescription->title = 'Отели в '.$titleCity.' "'.$slugs['city'].'",в "'.$slugs['area'].'" около метро  "'.$slugs['metro'].'"';                    
                    $pageDescription->meta_description = 'Бронирование отелей рядом с метро "'.$slugs['metro'].'" по минимальным ценам  ▶ Подробное описание номеров с фото и контактами ▶ Уютные номера с удобствами  ▶ Звоните!';
                }
            }
        } elseif (! empty($attrs)) {
            if (! empty($slugs['area'])) {
                // Округ + страница фильтрации по удобству
                $pageDescription->title = 'Отели в '.$titleCity.' "'.$slugs['city'].'",в "'.$slugs['area'].'" с выбранными условиями '.$attributes;
                $pageDescription->meta_description = 'Ищете отель? Бронируйте гостиничные номера на час (сутки) с '.$attributes.' в "'.$slugs['area'].'" Москвы ▶Описание номеров с фото  ▶ Звоните!';
            } else {
                // Просто страница фильтрации по удобству (все варианты удобств)
                $pageDescription->title = 'Отели в Москве со всеми удобствами в номере - бронь номеров онлайн';
                $pageDescription->meta_description = 'Выбирайте и бронируйте комфортабельные гостиничные номера на час (сутки) со всеми удобствами в компании Gorooms ▶Выгодные цены ▶Качественный сервис ▶ Звоните!';
            }
        }

        $title = '';
        if ($slugs['city']) {
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
        if ($attributes) {
            $desc_attr = ' с выбранными условиями '.$attributes;
        } else {
            $desc_attr = '';
        }
        $pageDescription->title = $desc_city.$desc_area.$desc_district.$desc_street.$desc_metro.$desc_attr;
        $pageDescription->url = "";

        return $pageDescription;
    }
}
