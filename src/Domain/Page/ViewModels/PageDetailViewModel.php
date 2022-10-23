<?php

declare(strict_types=1);

namespace Domain\Page\ViewModels;

use Domain\Page\DataTransferObjects\PageData;
use Domain\Page\Models\Page;

final class PageDetailViewModel extends \Parent\ViewModels\ViewModel
{
    public function __construct(
        public readonly ?Page $page = null
    ) {
    }

    public function page(): ?PageData
    {
        if (! $this->page) {
            return null;
        }

        return $this->page->load('meta', 'images')->getData();
    }
}
