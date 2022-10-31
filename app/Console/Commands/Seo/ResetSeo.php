<?php

namespace App\Console\Commands\Seo;

use Carbon\Carbon;
use Domain\Hotel\Models\Hotel;
use Domain\Hotel\Scopes\ModerationScope;
use Domain\PageDescription\Models\PageDescription;
use Illuminate\Console\Command;

class ResetSeo extends Command
{
    protected $signature = 'seo:reset-seo';

    public function handle(): int
    {
        $address = \Domain\Address\Models\Address::all();
        $createSeo = new \App\Helpers\CreateSeoUrls();
        foreach ($address as $a) {
            $createSeo->createUrlFromAddress($a, true, Carbon::now()->addDays(3));
        }

        $hotels = Hotel::withoutGlobalScope(ModerationScope::class)->get();
        foreach ($hotels as $a) {
            if ($a->address) {
                $createSeo->createUrlFromHotel($a, Carbon::now()->addDays(3));
            }
        }

        PageDescription::where('type', '!=', 'undefined')
          ->where('type', '!=', 'page')
          ->where('updated_at', '<', Carbon::now()->addDay())
          ->delete();

        return 0;
    }
}
