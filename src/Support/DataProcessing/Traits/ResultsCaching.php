<?php

declare(strict_types=1);

namespace Support\DataProcessing\Traits;

use Cache;
use Closure;
use Domain\Search\DataTransferObjects\ParamsData;
use Domain\User\Actions\GetLoggedUserModeratorStatusAction;

trait ResultsCaching
{   
    
    /**   
     * @param \Domain\Search\DataTransferObjects\ParamsData $paramsData
     * @param int|string $page
     * @param string $prefix
     * @return string
     */
    private function getHashFor(ParamsData $paramsData, int|string $page = 1, String $prefix = "search"): string
    {
        $paramsDataTmp = clone $paramsData;
        $paramsDataTmp->search = null;
        $paramsDataTmp->filter = false;
        $paramsDataTmp->hotel_id = null;
        $paramsDataTmp->as = null;

        $paramsHash = md5(serialize($paramsDataTmp));      

        return "{$prefix}-{$paramsHash}-{$page}";
    }

    
    /**    
     * @param \Domain\Search\DataTransferObjects\ParamsData $paramsData
     * @param int|string $page
     * @param string $prefix
     * @param \Closure $callback
     * @return mixed
     */
    private function getCahchedData(ParamsData $paramsData, int|string $page, String $prefix, Closure $callback)
    {        
        if ($paramsData->filter === true)
            return [];

        $isModerate = GetLoggedUserModeratorStatusAction::run();
        if ($isModerate)
            return $callback();
        
        return Cache::remember($this->getHashFor($paramsData, $page, $prefix), now()->addDays(7), $callback); 
    }
}
