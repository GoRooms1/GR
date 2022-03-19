<?php

namespace App\Helpers;

use Str;
use App\Models\Hotel;
use App\Models\Metro;
use App\Models\Address;
use App\Models\PageDescription;

class CreateSeoUrls
{
  private function getURlSeoFromAddress($address): array
  {
    $seo = [];

    $max = 3;

    if ($address->city) {
      $i = 0;
      while($i < $max) {
        $seo[$i] = new SeoData($address, '/address/' . Str::slug($address->city));
        $seo[$i]->lastOfType = 'city';
        $i++;
      }
    }

    if ($address->city_area) {
      $i = 0;
      while($i < $max - 1) {
        $seo[$i]->url.= '/area-' . Str::slug($address->city_area);
        $seo[$i]->lastOfType = 'area';
        $i++;
      }
    } else {
      $seo[1] = null;
    }

    if ($address->city_district) {
      $i = 0;
      while($i < $max - 2) {
        $seo[$i]->url .= '/district-' . Str::slug($address->city_district);
        $seo[$i]->lastOfType = 'district';
        $i++;
      }
    } else {
      $seo[0] = null;
    }

    return $seo;
  }

  public function createUrlFromAddress (Address $address, bool $override = false): CreateSeoUrls
  {
    $seo = $this->getURlSeoFromAddress($address);

    if ($hotel = $address->hotel()->withoutGlobalScope('moderation')->first()) {
      if ($hotel->metros()->count() > 0) {
        $metros_name = $hotel->metros()->pluck('name');
        foreach ($metros_name as $j => $name) {
          $seo[$j + 3] = new SeoData($address);
          $seo[$j + 3]->url = '/address/' . Str::slug($address->city) . '/metro-' . Str::slug($name);
          $seo[$j + 3]->metro = $name;
          $seo[$j + 3]->lastOfType = 'metro';
        }
      } 
    }

    $seo = array_filter($seo, static fn($item): bool => $item !== null);

    foreach ($seo as $key => $seoData) {
      if ($override && $seoData) {
        $seoData->generate();
        $pageDescription = PageDescription::updateOrCreate(['url' => $seoData->url], [
          'url' => $seoData->url,
          'title' => $seoData->title,
          'meta_description' => $seoData->description,
          'h1' => $seoData->h1,
          'type' => $seoData->lastOfType
        ]);
        $pageDescription->save();
      } else if (!PageDescription::where('url', $seoData->url)->exists() && $seoData) {
        $seoData->generate();
        $pageDescription = new PageDescription([
          'url' => $seoData->url,
          'title' => $seoData->title,
          'meta_description' => $seoData->description,
          'h1' => $seoData->h1,
          'type' => $seoData->lastOfType
        ]);
        $pageDescription->save();

      } else {
        $seo[$key] = null;
      }
    }

    return $this;
  }

  public function createUrlFromHotel (Hotel $hotel): CreateSeoUrls
  {
    $url = '/hotels/' . $hotel->slug;
    $seoData = new SeoData($hotel->address, $url);
    $seoData->lastOfType = 'hotel';
    $seoData->hotel = $hotel;
    $seoData->generate();
    $description = $hotel->meta->description ?? null;

    $pageDescription =  PageDescription::updateOrCreate(['url' => $url], [
      'url' => $seoData->url,
      'title' => $seoData->title,
      'meta_description' => $seoData->description,
      'h1' => $seoData->h1,
      'description' => $description,
      'type' => 'hotel'
    ]);
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
      PageDescription::where('url', '/address/' . Str::slug($address->city))->delete();
    }


    if ($address->city_area) {
      $count = Address::where('city', $address->city)
        ->where('city_area', $address->city_area)
        ->count();
      if ($count <= 1) {
        $url = '/address/' . Str::slug($address->city) . '/area-' . Str::slug($address->city_area);
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
          $url = '/address/' . Str::slug($address->city)
            . '/area-' . Str::slug($address->city_area)
            . '/district-' . Str::slug($address->city_district);
          PageDescription::where('url', $url)->delete();
        }
      } else {
        $count = Address::where('city', $address->city)
          ->where('city_district', $address->city_district)
          ->count();
        if ($count <= 1) {
          $url = '/address/' . Str::slug($address->city) . '/district-' . Str::slug($address->city_district);
          PageDescription::where('url', $url)->delete();
        }
      }
    }

    return $this;

  }

  public function createSeoFromMetro(Metro $metro): CreateSeoUrls
  {
    $hotel = $metro->hotel()->withoutGlobalScope('moderation')->first();
    if ($hotel) {
      $address = $hotel->address;
      $seo = new SeoData($address);
      $seo->url = '/address/' . Str::slug($address->city) . '/metro-' . Str::slug($metro->name);
      $seo->metro = $metro->name;
      $seo->lastOfType = 'metro';

      $seo->generate();
      $pageDescription = PageDescription::updateOrCreate(['url' => $seo->url], [
        'url' => $seo->url,
        'title' => $seo->title,
        'meta_description' => $seo->description,
        'h1' => $seo->h1,
        'type' => $seo->lastOfType
      ]);
      $pageDescription->save();
    }

    return $this;

  }
}