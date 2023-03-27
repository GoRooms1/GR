<?php

declare(strict_types=1);

namespace Domain\Home\ViewModels;

use Domain\Filter\DataTransferObjects\ParamsData;
use Domain\Filter\Traits\FiltersParamsTrait;
use Domain\Page\DataTransferObjects\PageData;
use Domain\PageDescription\Actions\GetPageDescriptionByUrlAction;
use Domain\Search\Traits\SearchResultTrait;

final class HomeViewModel extends \Parent\ViewModels\ViewModel
{
    use FiltersParamsTrait;
    use SearchResultTrait;

    /**
     * @param  ParamsData  $params
     */
    public function __construct(
        protected ParamsData $params
    ) {
    }

    /**
     * @return array{page: PageData}
     */
    public function model(): array
    {
        return [
            'page' => PageData::fromPageDescription(GetPageDescriptionByUrlAction::run('/')),
        ];
    }
}
