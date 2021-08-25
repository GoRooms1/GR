<?php

namespace App\Providers;

use App\Events\FormSend;
use App\Listeners\FormSendMailEvent;
use App\Models\Image;
use App\Models\Room;
use App\Observers\ImageObserver;
use App\Observers\RoomObserver;
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
    ]
  ];

  /**
   * Register any events for your application.
   *
   * @return void
   */
  public function boot()
  {
//        parent::boot();
    Image::observe(ImageObserver::class);
    Room::observe(RoomObserver::class);

  }
}
