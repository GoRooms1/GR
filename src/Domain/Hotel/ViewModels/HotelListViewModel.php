<?php

declare(strict_types=1);

namespace Domain\Hotel\ViewModels;

use Arr;
use Domain\Search\DataTransferObjects\ParamsData;
use Domain\Search\Traits\FiltersParamsTrait;
use Domain\Hotel\Actions\FilterHotelsPaginateAction;
use Domain\Hotel\DataTransferObjects\HotelData;
use Domain\Page\DataTransferObjects\PageData;
use Domain\PageDescription\Actions\GetPageDescriptionByUrlAction;
use Domain\Search\Traits\SearchResultTrait;
use Inertia\Inertia;
use Spatie\LaravelData\CursorPaginatedDataCollection;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;

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
