<?php

declare(strict_types=1);

namespace Domain\Attribute\Actions;

use Domain\Attribute\Model\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Action;

/**
 * @method static Collection run()
 */
final class GetFilteredAttributesAction extends Action
{
    /**
     * @return Collection
     */
    public function handle(): Collection
    {
        return Attribute::with('relationCategory')->filtered()->get();
    }
}
