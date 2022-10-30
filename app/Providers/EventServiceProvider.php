<?php

namespace App\Providers;

use App\Events\FormSend;
use App\Models\Image;
use App\Models\Room;
use App\Observers\AttributeObserver;
use App\Observers\CategoryObserver;
use App\Observers\CostTypeObserver;
use App\Observers\HotelObserver;
use App\Observers\ImageObserver;
use App\Observers\RoomObserver;
use Domain\Address\Models\Address;
use Domain\Address\Models\Metro;
use Domain\Address\Observers\AddressObserver;
use Domain\Address\Observers\MetroObserver;
use Domain\Attribute\Model\Attribute;
use Domain\Category\Models\Category;
use Domain\Hotel\Models\Hotel;
use Domain\Page\Listeners\FormSendMailEvent;
use Domain\Room\Models\CostType;
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

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
