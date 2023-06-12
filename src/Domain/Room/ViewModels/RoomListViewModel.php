<?php

declare(strict_types=1);

namespace Domain\Room\ViewModels;

use Cache;
use Closure;
use Domain\Search\DataTransferObjects\ParamsData;
use Domain\Search\Traits\FiltersParamsTrait;
use Domain\PageDescription\Actions\GetPageDescriptionByUrlAction;
use Domain\PageDescription\DataTransferObjects\PageDescriptionData;
use Domain\Room\Actions\FilterRoomsPaginateAction;
use Domain\Room\DataTransferObjects\RoomCardData;
use Domain\Search\Traits\SearchResultTrait;
use Domain\Settings\Models\Settings;
use Support\DataProcessing\Traits\ResultsCaching;

final class RoomListViewModel extends \Parent\ViewModels\ViewModel
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
        protected string $url = '/rooms'
    ) {
    }

    /**     
     * @return Closure
     */
    public function page_description(): Closure
    {
        return fn () => $this->params->filter ? null :
            PageDescriptionData::fromModel(GetPageDescriptionByUrlAction::run($this->url) ?? GetPageDescriptionByUrlAction::run('/rooms'));
    }

    /**
     * All paginated rooms
     * 
     * @return Closure
     */
    public function rooms(): Closure
    {
        $params = $this->params;
        $page = request()->get("page", 1);
       
        return fn() => $this->getCahchedData($params, $page, 'rooms', fn() => RoomCardData::collection(FilterRoomsPaginateAction::run($this->params->rooms, $this->params->hotels)));
    }
    
    public function default_description(): Closure 
    {
        return fn() => Cache::remember('seo_/rooms', now()->addDays(365), fn() => optional(Settings::where('option', 'seo_/rooms')->get()->first())->value);
    }
}
