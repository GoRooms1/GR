<?php

namespace App\Console\Commands\Seo;

use Domain\Hotel\DataTransferObjects\HotelData;
use Domain\Hotel\Models\Hotel;
use Domain\Page\Actions\GenerateSeoDataContent;
use Domain\Page\DataTransferObjects\SeoData;
use Domain\PageDescription\Models\PageDescription;
use Illuminate\Console\Command;

class ResetDescriptionSeoHotel extends Command
{
    protected $signature = 'seo:reset-description-seo-hotel';

    public function handle(): int
    {
        $this->alert('Start generate new Description for Hotel');

        $hotels = Hotel::withoutGlobalScope('moderation')->get();
        $count = 0;
        foreach ($hotels as $hotel) {
            if ($hotel->address) {
                $slug = '/hotels/'.$hotel->slug;
                $seoData = new SeoData($hotel->address, $slug);
                $seoData->lastOfType = 'hotel';
                $seoData->hotel = HotelData::fromModel($hotel);
                $seoData = GenerateSeoDataContent::run($seoData);

                $pd = PageDescription::where('url', $slug)->first();
                if ($pd) {
                    $pd->meta_description = $seoData->description;
                    $pd->save();
                } else {
                    $pd = new PageDescription([
                        'url' => $seoData->url,
                        'title' => $seoData->title,
                        'meta_description' => $seoData->description,
                        'h1' => $seoData->h1,
                        'description' => null,
                        'type' => 'hotel',
                    ]);
                    $pd->model_type = Hotel::class;
                    $pd->save();
                    $hotel->meta()->save($pd);
                }

                $count++;
            }
        }
        $this->info('Generate and save '.$count.' PageDescriptions -> Hotel');

        return 0;
    }
}
