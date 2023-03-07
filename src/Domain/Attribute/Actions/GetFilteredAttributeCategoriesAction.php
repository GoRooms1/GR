<?php

declare(strict_types=1);

namespace Domain\Attribute\Actions;

use Domain\Attribute\Model\Attribute;
use Domain\Attribute\Model\AttributeCategory;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Action;

/**
 * @method static Collection<AttributeCategory> run()
 */
final class GetFilteredAttributeCategoriesAction extends Action
{
    /**     
     * @return Collection<AttributeCategory>
     */
    public function handle(): Collection
    {        
        return AttributeCategory::whereHas('attributes', function ($q) {
            $q->where('in_filter', true);
        })->get();
    }
}
