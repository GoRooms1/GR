<?php

declare(strict_types=1);

namespace Domain\Attribute\Observers;

use Cache;
use Domain\Attribute\Model\Attribute;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * Saved with new data default
 */
final class AttributeObserver
{
    /**
     * Handle the Category "created" event.
     *
     * @param  Attribute  $attribute
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function created(Attribute $attribute): void
    {
        Cache::forget('hotels_attributes');
        Cache::forget('rooms_attributes');
    }

    /**
     * Handle the Category "updated" event.
     *
     * @param  Attribute  $attribute
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function updated(Attribute $attribute): void
    {
        Cache::forget('hotels_attributes');
        Cache::forget('rooms_attributes');
    }

    /**
     * Handle the Category "deleting" event.
     *
     * @param  Attribute  $attribute
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function deleting(Attribute $attribute): void
    {
        Cache::forget('hotels_attributes');
        Cache::forget('rooms_attributes');
    }

    /**
     * Handle the Category "deleted" event.
     *
     * @param  Attribute  $attribute
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function deleted(Attribute $attribute): void
    {
        Cache::forget('hotels_attributes');
        Cache::forget('rooms_attributes');
    }

    /**
     * Handle the Category "restored" event.
     *
     * @param  Attribute  $attribute
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function restored(Attribute $attribute): void
    {
        Cache::forget('hotels_attributes');
        Cache::forget('rooms_attributes');
    }

    /**
     * Handle the Category "force deleted" event.
     *
     * @param  \Domain\Attribute\Model\Attribute  $attribute
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function forceDeleted(Attribute $attribute): void
    {
        Cache::forget('hotels_attributes');
        Cache::forget('rooms_attributes');
    }
}
