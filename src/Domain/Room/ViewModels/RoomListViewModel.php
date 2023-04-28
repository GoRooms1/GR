<?php

declare(strict_types=1);

namespace Domain\Room\ViewModels;

use Arr;
use Domain\Search\DataTransferObjects\ParamsData;
use Domain\Search\Traits\FiltersParamsTrait;
use Domain\PageDescription\Actions\GetPageDescriptionByUrlAction;
use Domain\PageDescription\DataTransferObjects\PageDescriptionData;
use Domain\Room\Actions\FilterRoomsPaginateAction;
use Domain\Room\DataTransferObjects\RoomData;
use Domain\Search\Traits\SearchResultTrait;
use Inertia\Inertia;

final class RoomListViewModel extends \Parent\ViewModels\ViewModel
{
    use FiltersParamsTrait;
    use SearchResultTrait;

    /**
     * @param  ParamsData  $params
     * @param  string  $url
     */
    public function __construct(
        protected ParamsData $params,
        protected string $url = '/rooms'
    ) {
    }

    /**     
     * @return PageDescriptionData
     */
    public function page_description(): PageDescriptionData
    {        
        $pageDescription = GetPageDescriptionByUrlAction::run($this->url); 
        if (is_null($pageDescription))
            $pageDescription = GetPageDescriptionByUrlAction::run('/rooms');
       
        return PageDescriptionData::fromModel($pageDescription);
    }

    /**
     * All paginated rooms
     * 
     * @return \Inertia\LazyProp
     */
    public function rooms(): \Inertia\LazyProp
    {
        return Inertia::lazy(fn() => RoomData::collection(FilterRoomsPaginateAction::run($this->params->rooms, $this->params->hotels)));
    }

    /**
     * @return string
     */
    public function query_string(): string
    {
        return Arr::query($this->params->toArray());
    }
}
