<?php

declare(strict_types=1);

namespace Domain\Address\Builders;

use Illuminate\Database\Eloquent\Builder;

/**
 * @template TModelClass of \Domain\Address\Models\Metro
 * @extends Builder<TModelClass>
 */
final class MetroBuilder extends Builder
{    
    public function ordered(): self
    {
        return $this->orderBy('name');   
    }
    
    public function distinctName(): self
    {
        return $this->distinct('name');     
    }

    public function selectNameAndColor(): self
    {
        return $this->select('name', 'color');     
    }    
    
    public function whereCity($city): self
    {        
        return $this->whereIn('hotel_id', function($q) use ($city) {
            $q->select('hotel_id')
                ->from('addresses')
                ->whereRaw('LOWER(`city`) = ?', trim(strtolower($city)));
        });     
    }
}
