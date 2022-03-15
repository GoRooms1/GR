<?php

namespace App\Observers;

use App\Models\Address;
use App\Helpers\CreateSeoUrls;
use Illuminate\Support\Facades\Cache;

class AddressObserver
{
  /**
   * Handle the Address "created" event.
   *
   * @param Address $address
   *
   * @return void
   */
  public function created(Address $address): void
  {

    Address::setAddressesSlug($address);

    $createSeoUrls = new CreateSeoUrls();
    $createSeoUrls->createUrlFromAddress($address);
  }

  /**
   * Handle the Address "updated" event.
   *
   * @param Address $address
   *
   * @return void
   */
  public function updated(Address $address): void
  {
    Address::setAddressesSlug($address);

    $createSeoUrls = new CreateSeoUrls();
    $createSeoUrls->createUrlFromAddress($address);
  }

  /**
   * Handle the Address "deleted" event.
   *
   * @param Address $address
   *
   * @return void
   */
  public function deleted(Address $address): void
  {
    Cache::forget('sitemap.2g');
  }

  /**
   * Handle the Address "restored" event.
   *
   * @param Address $address
   *
   * @return void
   */
  public function restored(Address $address): void
  {
    //
  }

  /**
   * Handle the Address "force deleted" event.
   *
   * @param Address $address
   *
   * @return void
   */
  public function forceDeleted(Address $address): void
  {
    Cache::forget('sitemap.2g');
  }
}
