<?php

declare(strict_types=1);

namespace Domain\Address\Observers;

use App\Helpers\CreateSeoUrls;
use Domain\Address\Actions\SetAddressesSlug;
use Domain\Address\Models\Address;
use Illuminate\Support\Facades\Cache;

final class AddressObserver
{
    public function __construct(
        public CreateSeoUrls $createSeoUrls
    ) {
    }

    /**
     * Handle the Address "created" event.
     *
     * @param  Address  $address
     * @return void
     */
    public function created(Address $address): void
    {
        SetAddressesSlug::run($address);
        $this->createSeoUrls->createUrlFromAddress($address);
        Cache::forget('sitemap.2g');
    }

    /**
     * Handle the Address "updated" event.
     *
     * @param  Address  $address
     * @return void
     */
    public function updated(Address $address): void
    {
        SetAddressesSlug::run($address);
        $this->createSeoUrls->createUrlFromAddress($address);
        Cache::forget('sitemap.2g');
    }

    /**
     * Handle the Address "deleted" event.
     *
     * @param  Address  $address
     * @return void
     */
    public function deleted(Address $address): void
    {
        $this->createSeoUrls->deleteSeoFromAddress($address);
        Cache::forget('sitemap.2g');
    }

    /**
     * Handle the Address "restored" event.
     *
     * @param  Address  $address
     * @return void
     */
    public function restored(Address $address): void
    {
        //
    }

    /**
     * Handle the Address "force deleted" event.
     *
     * @param  Address  $address
     * @return void
     */
    public function forceDeleted(Address $address): void
    {
        $this->createSeoUrls->deleteSeoFromAddress($address);
        Cache::forget('sitemap.2g');
    }
}
