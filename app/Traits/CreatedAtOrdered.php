<?php
/**
 * Created by PhpStorm.
 * User: walft
 * Date: 09.08.2020
 * Time: 19:20
 */

namespace App\Traits;

use App\Scopes\CreatedAtOrderScope;

trait CreatedAtOrdered
{
    public static function getOrderDirection(): string
    {
        if (property_exists(static::class, 'orderDirection')) {
            return static::$orderDirection;
        }

        return 'DESC';
    }

    protected static function bootCreatedAtOrdered(): void
    {
        static::addGlobalScope(new CreatedAtOrderScope(self::getOrderDirection()));
    }
}
