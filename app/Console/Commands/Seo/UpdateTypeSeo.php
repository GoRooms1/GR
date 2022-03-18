<?php

namespace App\Console\Commands\Seo;

use Str;
use App\Models\Page;
use App\Models\Room;
use App\Models\Hotel;
use Illuminate\Console\Command;
use App\Models\PageDescription;

class UpdateTypeSeo extends Command
{
  protected $signature = 'seo:update-type-seo';

  public function handle(): int
  {
    $pageDescriptions = PageDescription::all();

    foreach ($pageDescriptions as $pageDescription) {
      if ($pageDescription->model_type === Hotel::class) {
        $pageDescription->type = 'hotel';
        $pageDescription->save();
        continue;
      }

      if ($pageDescription->model_type === Page::class) {
        $pageDescription->type = 'page';
        $pageDescription->save();
        continue;
      }

      if ($pageDescription->model_type === Room::class || Str::match('/(room)/', $pageDescription->url)) {
        $pageDescription->delete();
        continue;
      }

      $url = $pageDescription->url;

      if(Str::match('/(metro-)/', $url)) {
        $this->info(Str::match('/(metro-)/', $url));
        $this->info($url);
        $pageDescription->type = 'metro';
        $pageDescription->save();
        continue;
      }

      if(Str::match('/(street-)/', $url)) {
        $this->info(Str::match('/(street-)/', $url));
        $this->info($url);
        $pageDescription->type = 'street';
        $pageDescription->save();
        continue;
      }
      if(Str::match('/(district-)/', $url)) {
        $this->info(Str::match('/(district-)/', $url));
        $this->info($url);
        $pageDescription->type = 'district';
        $pageDescription->save();
        continue;
      }
      if(Str::match('/(area-)/', $url)) {
        $this->info(Str::match('/(area-)/', $url));
        $this->info($url);
        $pageDescription->type = 'area';
        $pageDescription->save();
        continue;
      }

      if(Str::match('/(address)/', $url)) {
        $this->info(Str::match('/(address-)/', $url));
        $this->info($url);
        $pageDescription->type = 'city';
        $pageDescription->save();
        continue;
      }

      $pageDescription->type = 'undefined';
      $pageDescription->save();
    }
    return 0;
  }
}