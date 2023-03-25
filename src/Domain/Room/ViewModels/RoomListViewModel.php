<?php

declare(strict_types=1);

namespace Domain\Room\ViewModels;

use Domain\Filter\DataTransferObjects\ParamsData;
use Domain\Filter\Traits\FiltersParamsTrait;
use Domain\Page\DataTransferObjects\PageData;
use Domain\PageDescription\Actions\GetPageDescriptionByUrlAction;
use Domain\Room\Actions\FilterRoomsPaginateAction;
use Domain\Room\DataTransferObjects\RoomData;
use Domain\Search\Traits\SearchResultTrait;
use Spatie\LaravelData\CursorPaginatedDataCollection;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;

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

    public function rooms(): DataCollection|CursorPaginatedDataCollection|PaginatedDataCollection
    {
        return RoomData::collection(FilterRoomsPaginateAction::run($this->params->rooms, $this->params->hotels));
    }
}
