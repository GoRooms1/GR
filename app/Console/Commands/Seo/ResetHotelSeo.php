<?php

namespace App\Console\Commands\Seo;

use Carbon\Carbon;
use App\Models\Hotel;
use Illuminate\Console\Command;
use App\Models\PageDescription;

class ResetHotelSeo extends Command
{
  protected $signature = 'seo:reset-hotel-seo';

  public function handle(): int
  {

    $createSeo = new \App\Helpers\CreateSeoUrls();

    $hotels = Hotel::withoutGlobalScope('moderation')->get();
    foreach ($hotels as $a) {
      if ($a->address) {
        $createSeo->createUrlFromHotel($a, Carbon::now()->addDays(3));
      }
    }

    $this->info('Hotel seo be end generate');
    return 0;
  }
}