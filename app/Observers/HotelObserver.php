<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

namespace App\Observers;

use App\Helpers\CreateSeoUrls;
use App\Models\Hotel;
use Cache;

class HotelObserver
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
