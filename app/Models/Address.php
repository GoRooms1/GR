<?php

namespace App\Models;

use App\Traits\ClearValidated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Address extends Model
{
  use ClearValidated;

  protected $fillable = [
    'postal_code',
    'country',
    'region',
    'area',
    'city',
    'city_district',
    'street',
    'house',
    'block',
    'flat',
    'office',
    'geo_lat',
    'geo_lon',
    'value',
    'street_type',
    'city_area',
    'street_with_type',
    'comment'
  ];

  public static function boot()
  {
    parent::boot();

    self::creating(function ($model) {
      self::setAddressesSlug($model);
    });

    self::updating(function ($model) {
      self::setAddressesSlug($model);
    });
    self::deleting(function (self $address) {
      Cache::forget('sitemap.2g');
    });
  }

  public static function setAddressesSlug($model)
  {
    $slugs = Address::getSlugFromAddress($model);
    Cache::forget('sitemap.2g');
    foreach ($slugs as $slug)
      DB::table('address_slug')->updateOrInsert(['address' => $slug['address']], $slug);
  }

  public static function getSlugFromAddress(Address $address)
  {
    $columns = ['region', 'area', 'city', 'city_district', 'street', 'city_area'];

    $slugs = [];
    foreach ($columns as $column) {
      $attribute = $address->getAttribute($column);
      if (!is_null($attribute) && !empty($attribute)) {
        $slugs[] = [
          'address' => $attribute,
          'slug' => Str::slug($attribute)
        ];
      }
    }

    return $slugs;
  }

  public function hotel(): BelongsTo
  {
    return $this->belongsTo(Hotel::class);
  }

  public function getCityAreaShortAttribute()
  {
    $areas = explode('-', $this->city_area);
    $area = '';
    foreach ($areas as $area_prefix)
      $area .= mb_substr($area_prefix, 0, 1);
    $area = mb_strtoupper($area) . 'АО';
    return $area;
  }
}
