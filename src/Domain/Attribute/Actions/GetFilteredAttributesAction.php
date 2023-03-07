<?php

declare(strict_types=1);

namespace Domain\Attribute\Actions;

use Domain\Attribute\Model\Attribute;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Action;

/**
 * @method static Collection<Attribute> run()
 */
final class GetFilteredAttributesAction extends Action
{
    /**     
     * @return Collection<Attribute>
     */
    public function handle(): Collection
    {        
        return Attribute::with('relationCategory')->filtered()->get();
    }
}
