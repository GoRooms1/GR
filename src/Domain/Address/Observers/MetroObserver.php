<?php

declare(strict_types=1);

namespace Domain\Address\Observers;

use App\Helpers\CreateSeoUrls;
use Domain\Address\Actions\GenerateSlugForMetro;
use Domain\Address\Models\Metro;
use Illuminate\Support\Facades\Cache;

final class MetroObserver
{
    /**
     * Handle the Metro "created" event.
     *
     * @param  \Domain\Address\Models\Metro  $metro
     * @return void
     */
    public function created(Metro $metro): void
    {
        GenerateSlugForMetro::run($metro->name);
        $csu = new CreateSeoUrls();
        $csu->createSeoFromMetro($metro);
        Cache::forget('sitemap.2g');
    }

    /**
     * Handle the Metro "updated" event.
     *
     * @param  \Domain\Address\Models\Metro  $metro
     * @return void
     */
    public function updated(Metro $metro): void
    {
        GenerateSlugForMetro::run($metro->name);
        $csu = new CreateSeoUrls();
        $csu->createSeoFromMetro($metro);
        Cache::forget('sitemap.2g');
    }

    /**
     * Handle the Metro "deleted" event.
     *
     * @param  \Domain\Address\Models\Metro  $metro
     * @return void
     */
    public function deleted(Metro $metro)
    {
        Cache::forget('sitemap.2g');
    }

    /**
     * Handle the Metro "restored" event.
     *
     * @param  \Domain\Address\Models\Metro  $metro
     * @return void
     */
    public function restored(Metro $metro): void
    {
        Cache::forget('sitemap.2g');
    }

    /**
     * Handle the Metro "force deleted" event.
     *
     * @param  \Domain\Address\Models\Metro  $metro
     * @return void
     */
    public function forceDeleted(Metro $metro): void
    {
        Cache::forget('sitemap.2g');
    }
}
