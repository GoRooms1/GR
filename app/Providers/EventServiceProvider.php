<?php

namespace App\Providers;

use App\Events\FormSend;
use App\Observers\CategoryObserver;
use Domain\Address\Models\Address;
use Domain\Address\Models\Metro;
use Domain\Address\Observers\AddressObserver;
use Domain\Address\Observers\MetroObserver;
use Domain\Attribute\Model\Attribute;
use Domain\Attribute\Observers\AttributeObserver;
use Domain\Category\Models\Category;
use Domain\Hotel\Models\Hotel;
use Domain\Hotel\Observers\HotelObserver;
use Domain\Image\Models\Image;
use Domain\Image\Observers\ImageObserver;
use Domain\Page\Listeners\FormSendMailEvent;
use Domain\Room\Models\CostType;
use Domain\Room\Models\Room;
use Domain\Room\Observers\CostTypeObserver;
use Domain\Room\Observers\RoomObserver;
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
