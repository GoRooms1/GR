<?php

namespace Domain\Page\Actions;

use Domain\Address\DataTransferObjects\MetroData;
use Domain\Hotel\Actions\MinimumCostsCalculation;
use Domain\Hotel\DataTransferObjects\HotelTypeData;
use Domain\Hotel\DataTransferObjects\MinCostsData;
use Domain\Page\DataTransferObjects\SeoData;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Action;

/**
 * @method static SeoData run(SeoData $seoData)
 */
final class GenerateSeoDataContent extends Action
{
    public function handle(SeoData $seoData): SeoData
    {
        if ($seoData->lastOfType === 'hotel' && $seoData->hotel) {
            return $this->generateSeoDataForHotel($seoData);
        }
        if ($seoData->url && $seoData->metro !== '') {
            return $this->generateSeoDataThroughUrl($seoData);
        }

        return $seoData;
    }

    protected function generateSeoDataForHotel(SeoData $seoData): SeoData
    {
        $type = $this->getHotelType($seoData);

        $seoData->h1 = $type.': '.$seoData->hotel?->name.' на улице '.$seoData->address?->street;
        $seoData->title = $seoData->hotel?->name.' '.Str::lower($type).' с Номерами на Час Ночь Сутки ';
        if ($seoData->hotel && $seoData->hotel->metros->count() > 0) {
            /** @var ?MetroData $metro */
            $metro = $seoData->hotel->metros->first();
            $seoData->title .= 'у метро '.$metro?->name;
        } else {
            $seoData->title .= 'в г. '.$seoData->address?->city;
        }
        if (! $seoData->hotel) {
            return $seoData;
        }
        $seoData->description = $type.' '.$seoData->hotel->name;
        $minimals = MinimumCostsCalculation::run($seoData->hotel);
        /** @var MinCostsData $minimal */
        foreach ($minimals as $minimal) {
            if ($minimal->name === 'На Час' && $minimal->value > 0) {
                $seoData->description .= ' с номерами от '.$minimal->value.' рублей в час';
            }
        }
        $seoData->description .= ', забронировать онлайн без комиссий. Описание и фотографии номеров, отзывы и фильтры с удобной сортировкой.';

        return $seoData;
    }

    protected function generateSeoDataThroughUrl(SeoData $seoData): SeoData
    {
        $city = $seoData->address?->city ?? '';
        $cityArea = $seoData->address->city_area ?? '';
        $cityDistrict = $seoData->address->city_district ?? '';
        if ($seoData->lastOfType === 'metro') {
            $seoData->title = 'Отели на час | Гостиницы на Час Ночь у метро '.$seoData->metro;
            $seoData->h1 = 'Гостиницы и отели у метро '.$seoData->metro.' — '.$city;
            $seoData->description = 'Забронируйте номер на Час | Ночь | Сутки около метро '.$seoData->metro.' ▶Без комиссий и посредников ▶Фотографии и описание номеров ▶Удобный поиск отелей!';
        } elseif ($seoData->lastOfType === 'district') {
            $seoData->title = 'Номера на Час Ночь | Почасовые отели | район '.$cityDistrict.' - '.$city;
            if ($cityArea) {
                $seoData->h1 = 'Отели и номера округ '.$cityArea.' район '.$cityDistrict.' - '.$city;
            } else {
                $seoData->h1 = 'Отели и номера район '.$cityDistrict.' - '.$city;
            }
            $seoData->description = 'Район '.$cityDistrict.', выбирайте и бронируйте гостиницу с почасовой оплатой номера в компании GoRooms ▶ Фото Номеров ▶Удобный поиск ▶ Подробное описание';
        } elseif ($seoData->lastOfType === 'area') {
            $seoData->title = 'Отель на час|ночь|сутки '.$cityArea.' округ - '.$city.' | Лучшие Цены';
            $seoData->h1 = 'Гостиницы и отели на час, ночь, сутки '.$cityArea.' округ - '.$city;
            $seoData->description = Str::ucfirst($cityArea).' округ снять номер на Час Ночь или Сутки, бронирование без комиссий, только актуальные фотографии и цены, самая большая база почасовых отелей.';
        } elseif ($seoData->lastOfType === 'city') {
            $seoData->title = 'Отели на Чаc Ночь Сутки | Почасовые Гостиницы г. '.$city;
            $seoData->h1 = 'Все почасовые отели города '.$city;
            $seoData->description = 'Ищете гостиницу в г. '.$city.'? Компания Gorooms поможет подобрать номер в отеле на час ночь или  сутки недорого ▶ Без комиссий и посредников ▶ Низкие цены ▶ Бронируйте уже сейчас!';
        }

        return $seoData;
    }

    private function getHotelType(SeoData $seoData): string
    {
        /** @var ?HotelTypeData $hotelType */
        $hotelType = $seoData->hotel?->type;
        $i = $hotelType?->name;
        if ($i === 'Отели') {
            $type = 'Отель';
        } else {
            $type = $hotelType?->name ?? '';
        }

        return $type;
    }
}
