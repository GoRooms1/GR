<?php

declare(strict_types=1);

namespace Domain\Hotel\Observers;

use App\Helpers\CreateSeoUrls;
use Cache;
use Domain\Hotel\Models\Hotel;

final class HotelObserver
{
    public CreateSeoUrls $csu;

    public function __construct()
    {
        $this->csu = new CreateSeoUrls();
    }

    /**
     * Handle the Category "created" event.
     *
     * @param  Hotel  $hotel
     * @return void
     */
    public function created(Hotel $hotel): void
    {
        Cache::flush();

        $hotel->moderate = true;
        $hotel->old_moderate = false;
        $hotel->show = false;

        $hotel->slug = $hotel->generateSlug();
        $hotel->save();

        if ($hotel->address) {
            $this->csu->createUrlFromHotel($hotel);
        }
        Cache::forget('sitemap.2g');
    }

    /**
     * Handle the Category "updated" event.
     *
     * @param  Hotel  $hotel
     * @return void
     */
    public function updated(Hotel $hotel): void
    {
        if ($hotel->address) {
            $this->csu->createUrlFromHotel($hotel);
        }
        Cache::flush();
    }

    /**
     * Handle the Category "deleting" event.
     *
     * @param  Hotel  $hotel
     * @return void
     */
    public function deleting(Hotel $hotel): void
    {
    }

    /**
     * Handle the Category "deleted" event.
     *
     * @param  Hotel  $hotel
     * @return void
     */
    public function deleted(Hotel $hotel): void
    {
        Cache::flush();

        $this->csu->deleteSeoFromHotel($hotel);
    }

    /**
     * Handle the Category "restored" event.
     *
     * @param  Hotel  $hotel
     * @return void
     */
    public function restored(Hotel $hotel): void
    {
        //
    }

    /**
     * Handle the Category "force deleted" event.
     *
     * @param  Hotel  $hotel
     * @return void
     */
    public function forceDeleted(Hotel $hotel): void
    {
        $this->csu->deleteSeoFromHotel($hotel);
    }
}
