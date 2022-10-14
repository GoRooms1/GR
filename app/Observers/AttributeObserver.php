<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

namespace App\Observers;

use App\Models\Attribute;
use App\Models\Category;
use Cache;
use Psr\SimpleCache\InvalidArgumentException;

/**
 * Saved with new data default
 */
class AttributeObserver
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
        Cache::delete('hotels_attributes');
        Cache::delete('rooms_attributes');
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
        Cache::delete('hotels_attributes');
        Cache::delete('rooms_attributes');
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
        Cache::delete('hotels_attributes');
        Cache::delete('rooms_attributes');
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
        Cache::delete('hotels_attributes');
        Cache::delete('rooms_attributes');
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
        Cache::delete('hotels_attributes');
        Cache::delete('rooms_attributes');
    }

    /**
     * Handle the Category "force deleted" event.
     *
     * @param  Attribute  $attribute
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function forceDeleted(Attribute $attribute): void
    {
        Cache::delete('hotels_attributes');
        Cache::delete('rooms_attributes');
    }
}
