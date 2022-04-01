<?php

namespace App\Providers;

use App\Models\Room;
use App\Models\Hotel;
use App\Models\Image;
use App\Models\Metro;
use App\Models\Address;
use App\Events\FormSend;
use App\Models\Category;
use App\Models\CostType;
use App\Models\Attribute;
use App\Observers\RoomObserver;
use App\Observers\HotelObserver;
use App\Observers\ImageObserver;
use App\Observers\MetroObserver;
use App\Observers\AddressObserver;
use App\Observers\CategoryObserver;
use App\Observers\CostTypeObserver;
use App\Listeners\FormSendMailEvent;
use App\Observers\AttributeObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
  /**
   * The event listener mappings for the application.
   *
   * @var array
   */
  protected $listen = [
    Registered::class => [
      SendEmailVerificationNotification::class,
    ],
    FormSend::class => [
      FormSendMailEvent::class,
    ],
  ];

  /**
   * Register any events for your application.
   *
   * @return void
   */
  public function boot(): void
  {
//        parent::boot();
    Image::observe(ImageObserver::class);
    Room::observe(RoomObserver::class);
    Category::observe(CategoryObserver::class);
    Hotel::observe(HotelObserver::class);
    Attribute::observe(AttributeObserver::class);
    Address::observe(AddressObserver::class);
    CostType::observe(CostTypeObserver::class);
    Metro::observe(MetroObserver::class);
  }
}
