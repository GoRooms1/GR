<?php

declare(strict_types=1);

namespace Domain\Hotel\ViewModels;

use Arr;
use Domain\Search\DataTransferObjects\ParamsData;
use Domain\Search\Traits\FiltersParamsTrait;
use Domain\Hotel\Actions\FilterHotelsPaginateAction;
use Domain\Hotel\DataTransferObjects\HotelData;
use Domain\PageDescription\Actions\GetPageDescriptionByUrlAction;
use Domain\PageDescription\DataTransferObjects\PageDescriptionData;
use Domain\Search\Traits\SearchResultTrait;
use Inertia\Inertia;

final class HotelListViewModel extends \Parent\ViewModels\ViewModel
{
    use FiltersParamsTrait;
    use SearchResultTrait;

    /**
     * @param  ParamsData  $params
     * @param  string  $url
     */
    public function __construct(
        protected ParamsData $params,
        protected string $url = '/hotels'      
    ) {
    }
   
    /**     
     * @return PageDescriptionData
     */
    public function page_description(): PageDescriptionData
    {        
        $pageDescription = GetPageDescriptionByUrlAction::run($this->url);
        if (is_null($pageDescription))
            $pageDescription = GetPageDescriptionByUrlAction::run('/hotels');
       
        return PageDescriptionData::fromModel($pageDescription);
    }

    /**
     * Paginated hotels array
     *
     * @return \Inertia\LazyProp
     */
    public function hotels(): \Inertia\LazyProp
    {
        return Inertia::lazy(fn() => HotelData::collection(FilterHotelsPaginateAction::run($this->params->hotels)));
    }

    /**
     * @return string
     */
    public function query_string(): string
    {
        return Arr::query($this->params->toArray());
    }
}
