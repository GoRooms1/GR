<?php

namespace App\Helpers;

use Str;
use App\Models\Address;
use App\Models\PageDescription;

class CreateSeoUrls
{

  public function createUrlFromAddress (Address $address): void
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

    $address->city_area = null;

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

    $metros_name = $address->hotel->metros()->pluck('name');
    foreach ($metros_name as $j => $name) {
      $seo[$j + 3] = new SeoData($address);
      $seo[$j + 3]->url = '/address/' . Str::slug($address->city) . '/metro-' . Str::slug($name);
      $seo[$j + 3]->metro = $name;
      $seo[$j + 3]->lastOfType = 'metro';
    }

    $seo = array_filter($seo, static fn($item): bool => $item !== null);

    foreach ($seo as $key => $seoData) {
      if (!PageDescription::where('url', $seoData->url)->exists())  {
        $seoData->generate();

        $pageDescription = new PageDescription([
          'url' => $seoData->url,
          'title' => $seoData->title,
          'meta_description' => $seoData->description,

        ]);

      } else {
        $seo[$key] = null;
      }
    }

    $seo = array_filter($seo, static fn($item): bool => $item !== null);

    dd($seo);

  }
}