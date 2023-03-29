<?php

declare(strict_types=1);

namespace Domain\Address\Actions;

use Domain\Address\Models\Metro;
use Lorisleiva\Actions\Action;
use Support\DataProcessing\Traits\CustomStr;

/**
 * @method static string run(Metro $metro)
 */
final class GetMetroSlugAction extends Action
{
    /**     
     * @param Metro $metro
     * @return string
     */
    public function handle(Metro $metro): string
    {
       return '/'.CustomStr::getCustomSlug($metro->hotel->address->city).'/metro-'.CustomStr::getCustomSlug($metro->name);
    }
}
