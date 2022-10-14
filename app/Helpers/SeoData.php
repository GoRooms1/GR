<?php

namespace App\Helpers;

use App\Models\Address;
use App\Models\Hotel;
use Str;

class SeoData
{
    public ?string $url;

    public string $title;

    public string $h1;

    public string $description;

    public ?string $metro = null;

    public string $lastOfType = '';

    public ?Hotel $hotel;

    public Address $address;

    public function __construct(Address $address, $url = null)
    {
        $this->address = $address;
        $this->url = $url;
    }

    public function generate(): bool
    {
        if ($this->lastOfType === 'hotel' && $this->hotel) {
            $i = $this->hotel->type->name;
            if ($i === 'Отели') {
                $type = 'Отель';
            } else {
                $type = $this->hotel->type->name;
            }

            $this->h1 = $type.': '.$this->hotel->name.' на улице '.$this->address->street;
            $this->title = $this->hotel->name.' '.Str::lower($type).' с Номерами на Час Ночь Сутки ';
            if ($this->hotel->metros()->count() > 0) {
                $this->title .= 'у метро '.$this->hotel->metros()->first()->name;
            } else {
                $this->title .= 'в г. '.$this->address->city;
            }

            $this->description = $type.' '.$this->hotel->name;
            foreach ($this->hotel->minimals as $minimal) {
                if ($minimal->name === 'На Час' && $minimal->value > 0) {
                    $this->description .= ' с номерами от '.$minimal->value.' рублей в час';
                }
            }
            $this->description .= ', забронировать онлайн без комиссий. Описание и фотографии номеров, отзывы и фильтры с удобной сортировкой.';

            return true;
        }
        if ($this->url && $this->metro !== '') {
            if ($this->lastOfType === 'metro') {
                $this->title = 'Отели на час | Гостиницы на Час Ночь у метро '.$this->metro;
                $this->h1 = 'Гостиницы и отели у метро '.$this->metro.' — '.$this->address->city;
                $this->description = 'Забронируйте номер на Час | Ночь | Сутки около метро '.$this->metro.' ▶Без комиссий и посредников ▶Фотографии и описание номеров ▶Удобный поиск отелей!';
            } elseif ($this->lastOfType === 'district') {
                $this->title = 'Номера на Час Ночь | Почасовые отели | район '.$this->address->city_district.' - '.$this->address->city;
                if ($this->address->city_area) {
                    $this->h1 = 'Отели и номера округ '.$this->address->city_area.' район '.$this->address->city_district.' - '.$this->address->city;
                } else {
                    $this->h1 = 'Отели и номера район '.$this->address->city_district.' - '.$this->address->city;
                }
                $this->description = 'Район '.$this->address->city_district.', выбирайте и бронируйте гостиницу с почасовой оплатой номера в компании GoRooms ▶ Фото Номеров ▶Удобный поиск ▶ Подробное описание';
            } elseif ($this->lastOfType === 'area') {
                $this->title = 'Отель на час|ночь|сутки '.$this->address->city_area.' округ - '.$this->address->city.' | Лучшие Цены';
                $this->h1 = 'Гостиницы и отели на час, ночь, сутки '.$this->address->city_area.' округ - '.$this->address->city;
                $this->description = Str::ucfirst($this->address->city_area).' округ снять номер на Час Ночь или Сутки, бронирование без комиссий, только актуальные фотографии и цены, самая большая база почасовых отелей.';
            } elseif ($this->lastOfType === 'city') {
                $this->title = 'Отели на Чаc Ночь Сутки | Почасовые Гостиницы г. '.$this->address->city;
                $this->h1 = 'Все почасовые отели города '.$this->address->city;
                $this->description = 'Ищете гостиницу в г. '.$this->address->city.'? Компания Gorooms поможет подобрать номер в отеле на час ночь или  сутки недорого ▶ Без комиссий и посредников ▶ Низкие цены ▶ Бронируйте уже сейчас!';
            }

            return true;
        }

        return false;
    }
}
