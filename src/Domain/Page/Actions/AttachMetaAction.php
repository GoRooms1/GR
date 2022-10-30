<?php

declare(strict_types=1);

namespace Domain\Page\Actions;

use Domain\Page\DataTransferObjects\PageData;
use Domain\Page\Models\Page;
use Domain\PageDescription\DataTransferObjects\PageDescriptionData;
use Domain\PageDescription\Models\PageDescription;

/**
 * @method static PageData run()
 */
final class AttachMetaAction extends \Parent\Actions\Action
{
    public function handle(Page $page, PageDescriptionData $pageDescriptionData): PageData
    {
        if (! $pageDescriptionData->title && ! $pageDescriptionData->meta_description && ! $pageDescriptionData->meta_keywords) {
            return PageData::fromModel($page);
        }

        $meta = PageDescription::updateOrCreate(['url' => $pageDescriptionData->url], $pageDescriptionData->toArray());
        $meta->model_type = $page::class;
        $meta->save();

        $page->meta()->save($meta);

        return PageData::fromModel($page);
    }
}
