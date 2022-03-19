<?php

namespace App\Console\Commands\Hotels;

use App\Models\Hotel;
use Illuminate\Console\Command;

class CreateSeo extends Command
{
  protected $signature = 'hotels:create-seo';

  public function handle(): int
  {
    $address = \App\Models\Address::all();
    $createSeo = new \App\Helpers\CreateSeoUrls();
    foreach ($address as $a) {
      $createSeo->createUrlFromAddress($a, true);
    }

//    $hotels = Hotel::withoutGlobalScope('moderation')->get();
//    foreach ($hotels as $a) {
//      if ($a->address) {
//        $createSeo->createUrlFromHotel($a);
//      }
//    }
    return 0;
  }
}