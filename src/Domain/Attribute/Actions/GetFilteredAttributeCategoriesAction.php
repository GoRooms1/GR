<?php

declare(strict_types=1);

namespace Domain\Attribute\Actions;

use Domain\Attribute\Model\AttributeCategory;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Action;

/**
 * @method static Collection run()
 */
final class GetFilteredAttributeCategoriesAction extends Action
{
    /**
     * @return Collection
     */
    public function handle(): Collection
    {
        return AttributeCategory::whereHas('attributes', function ($q) {
            $q->where('in_filter', true);
        })->get();
    }
}
