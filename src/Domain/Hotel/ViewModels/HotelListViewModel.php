<?php

declare(strict_types=1);

namespace Domain\Hotel\ViewModels;

use Arr;
use Domain\Filter\DataTransferObjects\ParamsData;
use Domain\Filter\Traits\FiltersParamsTrait;
use Domain\Hotel\Actions\FilterHotelsPaginateAction;
use Domain\Hotel\DataTransferObjects\HotelData;
use Domain\Page\DataTransferObjects\PageData;
use Domain\PageDescription\Actions\GetPageDescriptionByUrlAction;
use Domain\Search\Traits\SearchResultTrait;
use Spatie\LaravelData\CursorPaginatedDataCollection;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;

/**
 * Summary of HotelListViewModel
 */
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
     * @return array{page: PageData}
     */
    public function model(): array
    {
        return [
            'page' => PageData::fromPageDescription(GetPageDescriptionByUrlAction::run($this->url)),
        ];
    }

    /**
     * Paginated hotels array
     *
     * @return DataCollection|CursorPaginatedDataCollection|PaginatedDataCollection
     */
    public function hotels(): DataCollection|CursorPaginatedDataCollection|PaginatedDataCollection
    {
        return HotelData::collection(FilterHotelsPaginateAction::run($this->params->hotels));
    }

    /**
     * @return string
     */
    public function query_string(): string
    {
        return Arr::query($this->params->toArray());
    }
}
