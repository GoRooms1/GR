<?php

namespace App\Helpers;

use Domain\Address\DataTransferObjects\AddressData;
use Domain\Address\Models\Address;
use Domain\Address\Models\Metro;
use Domain\Hotel\DataTransferObjects\HotelData;
use Domain\Hotel\Models\Hotel;
use Domain\Hotel\Scopes\ModerationScope;
use Domain\Page\Actions\GenerateSeoDataContent;
use Domain\Page\DataTransferObjects\SeoData;
use Domain\PageDescription\Models\PageDescription;
use Str;
use Support\DataProcessing\Traits\CustomStr;

class CreateSeoUrls
{
    /**
     * @param $address
     * @return SeoData[]
     */
    private function getURlSeoFromAddress($address): array
    {
        $seo = [];

        $max = 3;

        if ($address->city) {
            $i = 0;
            while ($i < $max) {
                $seoData = new SeoData();
                $seoData->address = AddressData::from($address);
                $seoData->url = '/address/'.CustomStr::getCustomSlug($address->city);
                $seoData->lastOfType = 'city';
                $seo[$i] = $seoData;
                $i++;
            }
        }

        if ($address->city_area) {
            $i = 0;
            while ($i < $max - 1) {
                $seo[$i]->url .= '/area-'.CustomStr::getCustomSlug($address->city_area);
                $seo[$i]->lastOfType = 'area';
                $i++;
            }
        } else {
            $seo[1] = null;
        }

        if ($address->city_district) {
            $i = 0;
            while ($i < $max - 2) {
                $seo[$i]->url .= '/district-'.CustomStr::getCustomSlug($address->city_district);
                $seo[$i]->lastOfType = 'district';
                $i++;
            }
        } else {
            $seo[0] = null;
        }

        return $seo;
    }

    public function createUrlFromAddress(Address $address, bool $override = false, $date = null): CreateSeoUrls
    {
        $seo = $this->getURlSeoFromAddress($address);

        if ($hotel = $address->hotel()->withoutGlobalScope(ModerationScope::class)->first()) {
            if ($hotel->metros()->count() > 0) {
                $metros_name = $hotel->metros()->pluck('name');
                foreach ($metros_name as $j => $name) {
                    $seo[$j + 3] = new SeoData($address);
                    $seo[$j + 3]->url = '/address/'.CustomStr::getCustomSlug($address->city).'/metro-'.CustomStr::getCustomSlug($name);
                    $seo[$j + 3]->metro = $name;
                    $seo[$j + 3]->lastOfType = 'metro';
                }
            }
        }

        $seo = array_filter($seo, static fn ($item): bool => $item !== null);

        foreach ($seo as $key => $seoData) {
            if ($override && $seoData) {
                $seoData = GenerateSeoDataContent::run($seoData);
                $data = [
                    'url' => $seoData->url,
                    'title' => $seoData->title,
                    'meta_description' => $seoData->description,
                    'h1' => $seoData->h1,
                    'type' => $seoData->lastOfType,
                ];

                if ($date) {
                    $data['updated_at'] = $date;
                }

                $pageDescription = PageDescription::updateOrCreate(['url' => $seoData->url], $data);
                $pageDescription->save();
            } elseif (! PageDescription::where('url', $seoData->url)->exists() && $seoData) {
                $seoData = GenerateSeoDataContent::run($seoData);
                $data = [
                    'url' => $seoData->url,
                    'title' => $seoData->title,
                    'meta_description' => $seoData->description,
                    'h1' => $seoData->h1,
                    'type' => $seoData->lastOfType,
                ];
                if ($date) {
                    $data['updated_at'] = $date;
                }
                $pageDescription = new PageDescription($data);
                $pageDescription->save();
            } else {
                $seo[$key] = null;
            }
        }

        return $this;
    }

    public function createUrlFromHotel(Hotel $hotel, $date = null): CreateSeoUrls
    {
        $url = '/hotels/'.$hotel->slug;
        $seoData = new SeoData($hotel->address, $url);
        $seoData->lastOfType = 'hotel';
        $seoData->hotel = HotelData::fromModel($hotel);
        $seoData = GenerateSeoDataContent::run($seoData);

        $description = $hotel->meta->description ?? null;

        $data = [
            'url' => $url,
            'title' => $seoData->title,
            'meta_description' => $seoData->description,
            'h1' => $seoData->h1,
            'description' => $description,
            'type' => 'hotel',
        ];
        if ($date) {
            $data['updated_at'] = $date;
        }
        
        $pageDescription = PageDescription::updateOrCreate(['url' => $url], $data);
        $pageDescription->model_type = Hotel::class;
        $pageDescription->save();
        $hotel->meta()->save($pageDescription);

        return $this;
    }

    public function deleteSeoFromHotel(Hotel $hotel): CreateSeoUrls
    {
        PageDescription::where('model_id', $hotel->id)
          ->where('model_type', Hotel::class)
          ->delete();

        return $this;
    }

    public function deleteSeoFromAddress(Address $address): CreateSeoUrls
    {
        if (Address::where('city', $address->city)->count() <= 1) {
            PageDescription::where('url', '/address/'.CustomStr::getCustomSlug($address->city))->delete();
        }

        if ($address->city_area) {
            $count = Address::where('city', $address->city)
              ->where('city_area', $address->city_area)
              ->count();
            if ($count <= 1) {
                $url = '/address/'.CustomStr::getCustomSlug($address->city).'/area-'.CustomStr::getCustomSlug($address->city_area);
                PageDescription::where('url', $url)->delete();
            }
        }

        if ($address->city_district) {
            if ($address->city_area) {
                $count = Address::where('city', $address->city)
                  ->where('city_area', $address->city_area)
                  ->where('city_district', $address->city_district)
                  ->count();
                if ($count <= 1) {
                    $url = '/address/'.CustomStr::getCustomSlug($address->city)
                      .'/area-'.CustomStr::getCustomSlug($address->city_area)
                      .'/district-'.CustomStr::getCustomSlug($address->city_district);
                    PageDescription::where('url', $url)->delete();
                }
            } else {
                $count = Address::where('city', $address->city)
                  ->where('city_district', $address->city_district)
                  ->count();
                if ($count <= 1) {
                    $url = '/address/'.CustomStr::getCustomSlug($address->city).'/district-'.CustomStr::getCustomSlug($address->city_district);
                    PageDescription::where('url', $url)->delete();
                }
            }
        }

        return $this;
    }

    public function createSeoFromMetro(Metro $metro): CreateSeoUrls
    {
        $hotel = $metro->hotel()->withoutGlobalScope(ModerationScope::class)->first();
        if ($hotel) {
            $address = $hotel->address;
            $seo = new SeoData($address);
            $seo->url = '/address/'.CustomStr::getCustomSlug($address->city).'/metro-'.CustomStr::getCustomSlug($metro->name);
            $seo->metro = $metro->name;
            $seo->lastOfType = 'metro';
            if ($address)
                $seo->address = AddressData::fromModel($address);

            $seo = GenerateSeoDataContent::run($seo);
            $pageDescription = PageDescription::updateOrCreate(['url' => $seo->url], [
                'url' => $seo->url,
                'title' => $seo->title,
                'meta_description' => $seo->description,
                'h1' => $seo->h1,
                'type' => $seo->lastOfType,
            ]);
            $pageDescription->save();
        }

        return $this;
    }
}
