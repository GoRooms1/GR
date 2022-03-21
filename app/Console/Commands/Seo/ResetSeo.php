<?php

namespace App\Console\Commands\Seo;

use Carbon\Carbon;
use App\Models\Hotel;
use Illuminate\Console\Command;
use App\Models\PageDescription;

class ResetSeo extends Command
{
  protected $signature = 'seo:reset-seo';

  public function handle(): int
  {

    $address = \App\Models\Address::all();
    $createSeo = new \App\Helpers\CreateSeoUrls();
    foreach ($address as $a) {
      $createSeo->createUrlFromAddress($a, true, Carbon::now()->addDays(3));
    }

    $hotels = Hotel::withoutGlobalScope('moderation')->get();
    foreach ($hotels as $a) {
      if ($a->address) {
        $createSeo->createUrlFromHotel($a, Carbon::now()->addDays(3));
      }
    }

    PageDescription::where('type', '!=', 'undefined')
      ->where('type','!=', 'page')
      ->where('updated_at', '<', Carbon::now()->addDay())
      ->delete();
    return 0;
  }
}