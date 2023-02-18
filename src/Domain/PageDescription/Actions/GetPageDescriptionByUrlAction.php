<?php

declare(strict_types=1);

namespace Domain\PageDescription\Actions;

use Domain\PageDescription\DataTransferObjects\PageDescriptionData;
use Domain\PageDescription\Models\PageDescription;
use Lorisleiva\Actions\Action;

/**
 * @method static PageDescription | Null run(string $url)
 */
final class GetPageDescriptionByUrlAction extends Action
{
    public function handle(string $url): PageDescription | Null
    {        
        $data = PageDescription::whereUrl($url)->first();
        return $data;
    }
}
