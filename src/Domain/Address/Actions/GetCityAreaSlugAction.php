<?php

declare(strict_types=1);

namespace Domain\Address\Actions;

use Domain\Address\Models\Address;
use Lorisleiva\Actions\Action;
use Support\DataProcessing\Traits\CustomStr;

/**
 * @method static string run(Address $address)
 */
final class GetCityAreaSlugAction extends Action
{
    /**     
     * @param Address $address
     * @return string
     */
    public function handle(Address $address): string
    {
       return route('address').'/'.CustomStr::getCustomSlug($address->city).'/area-'.CustomStr::getCustomSlug($address->city_area);
    }
}
