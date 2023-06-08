<?php

declare(strict_types=1);

namespace Support\DataProcessing\Traits;

use Domain\Search\DataTransferObjects\ParamsData;

trait ResultsCaching
{   
    public function getHashFor(ParamsData $paramsData, int $page = 1, $prefix = "search"): string
    {
        $paramsDataTmp = clone $paramsData;
        $paramsDataTmp->search = null;
        $paramsDataTmp->filter = false;
        $paramsDataTmp->hotel_id = null;

        $paramsHash = md5(serialize($paramsDataTmp));      

        return "{$prefix}-{$paramsHash}-{$page}";
    }
}
