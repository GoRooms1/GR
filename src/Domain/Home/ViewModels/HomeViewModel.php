<?php

declare(strict_types=1);

namespace Domain\Home\ViewModels;

use Domain\Filter\Traits\FiltersParamsTrait;
use Domain\Page\DataTransferObjects\PageData;
use Domain\PageDescription\Actions\GetPageDescriptionByUrlAction;

final class HomeViewModel extends \Parent\ViewModels\ViewModel
{
    use FiltersParamsTrait;

    public array $params = [];

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function model()
    {
        return [
            'page' => PageData::fromPageDescription(GetPageDescriptionByUrlAction::run('/'))->toArray(),
        ];
    }
}
