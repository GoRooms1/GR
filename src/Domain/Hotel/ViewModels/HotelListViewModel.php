<?php

declare(strict_types=1);

namespace Domain\Hotel\ViewModels;

use Closure;
use Domain\Search\DataTransferObjects\ParamsData;
use Domain\Search\Traits\FiltersParamsTrait;
use Domain\Hotel\Actions\FilterHotelsPaginateAction;
use Domain\Hotel\DataTransferObjects\HotelCardData;
use Domain\PageDescription\Actions\GetPageDescriptionByUrlAction;
use Domain\PageDescription\DataTransferObjects\PageDescriptionData;
use Domain\Search\Traits\SearchResultTrait;
use Support\DataProcessing\Traits\ResultsCaching;

final class HotelListViewModel extends \Parent\ViewModels\ViewModel
{
    use FiltersParamsTrait;
    use SearchResultTrait;
    use ResultsCaching;

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
     * @return Closure
     */
    public function page_description(): Closure
    {
        return fn () => $this->params->filter ? null :
            PageDescriptionData::fromModel(GetPageDescriptionByUrlAction::run($this->url) ?? GetPageDescriptionByUrlAction::run('/hotels'));
    }

    /**
     * Paginated hotels array
     *
     * @return Closure
     */
    public function hotels(): Closure
    {        
        $params = $this->params;
        $page = request()->get("page", 1);

        return fn() => $this->getCahchedData($params, $page, 'hotels', fn() => HotelCardData::collection(FilterHotelsPaginateAction::run($params->hotels)));
    }
}
