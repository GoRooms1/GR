<?php

namespace App\Observers;

use App\Helpers\CreateSeoUrls;
use App\Models\Metro;
use Illuminate\Support\Facades\Cache;

class MetroObserver
{
    /**
     * Handle the Metro "created" event.
     *
     * @param  Metro  $metro
     * @return void
     */
    public function created(Metro $metro): void
    {
        Metro::generateSlug($metro);
        $csu = new CreateSeoUrls();
        $csu->createSeoFromMetro($metro);
        Cache::forget('sitemap.2g');
    }

    /**
     * Handle the Metro "updated" event.
     *
     * @param  Metro  $metro
     * @return void
     */
    public function updated(Metro $metro): void
    {
        Metro::generateSlug($metro);
        $csu = new CreateSeoUrls();
        $csu->createSeoFromMetro($metro);
        Cache::forget('sitemap.2g');
    }

    /**
     * Handle the Metro "deleted" event.
     *
     * @param  Metro  $metro
     * @return void
     */
    public function deleted(Metro $metro)
    {
        Cache::forget('sitemap.2g');
    }

    /**
     * Handle the Metro "restored" event.
     *
     * @param  Metro  $metro
     * @return void
     */
    public function restored(Metro $metro): void
    {
        Cache::forget('sitemap.2g');
    }

    /**
     * Handle the Metro "force deleted" event.
     *
     * @param  Metro  $metro
     * @return void
     */
    public function forceDeleted(Metro $metro): void
    {
        Cache::forget('sitemap.2g');
    }
}
