<?php

declare(strict_types=1);

namespace Domain\Room\ViewModels;

use Domain\Filter\Traits\FiltersParamsTrait;
use Domain\Page\DataTransferObjects\PageData;
use Domain\PageDescription\Actions\GetPageDescriptionByUrlAction;
use Domain\Room\Actions\FilterRoomsAction;
use Domain\Room\DataTransferObjects\RoomData;

final class RoomListViewModel extends \Parent\ViewModels\ViewModel
{
    use FiltersParamsTrait;

    /**
     * @param  array<string, string|int|array|bool>  $params
     * @todo instead of array pass DTO
     */
    public function __construct(
        // $paramData
        protected array $params
    )
    {}

    /**
     * @return array<string, array<string, string|int|array|null>>
     */
    public function model(): array
    {
        return [
            'page' => PageData::fromPageDescription(
                GetPageDescriptionByUrlAction::run('/rooms')
            )->toArray(),
        ];
    }

    public function rooms(): \Spatie\LaravelData\DataCollection|\Spatie\LaravelData\CursorPaginatedDataCollection|\Spatie\LaravelData\PaginatedDataCollection
    {
        return RoomData::collection(FilterRoomsAction::run($this->params['rooms'] ?? [], $this->params['hotels'] ?? [], true));
    }
}
