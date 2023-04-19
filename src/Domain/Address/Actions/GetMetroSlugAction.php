<?php

declare(strict_types=1);

namespace Domain\Address\Actions;

use Domain\Address\Models\Metro;
use Lorisleiva\Actions\Action;
use Support\DataProcessing\Traits\CustomStr;

/**
 * @method static string run(String $metroName, String $cityName)
 */
final class GetMetroSlugAction extends Action
{   
    /**     
     * @param string $metroName
     * @param string $cityName
     * @return string
     */
    public function handle(String $metroName, String $cityName): string
    {
       return '/'.CustomStr::getCustomSlug($cityName).'/metro-'.CustomStr::getCustomSlug($metroName);
    }
}
