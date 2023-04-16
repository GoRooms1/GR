<?php

declare(strict_types=1);

namespace Domain\Room\ViewModels;

use Domain\Search\DataTransferObjects\ParamsData;
use Domain\Search\Traits\FiltersParamsTrait;
use Domain\Page\DataTransferObjects\PageData;
use Domain\PageDescription\Actions\GetPageDescriptionByUrlAction;
use Domain\Room\Actions\FilterRoomsPaginateAction;
use Domain\Room\DataTransferObjects\RoomData;
use Domain\Search\Traits\SearchResultTrait;
use Inertia\Inertia;
use Spatie\LaravelData\CursorPaginatedDataCollection;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;

/**
 * Summary of RoomListViewModel
 */
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
     * @return array{page: PageData}>
     */
    public function model(): array
    {
        return [
            'page' => PageData::fromPageDescription(
                GetPageDescriptionByUrlAction::run($this->url)
            ),
        ];
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
}
