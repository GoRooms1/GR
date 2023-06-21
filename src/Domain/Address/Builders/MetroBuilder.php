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

    /**
     * @param  string  $city
     * @return MetroBuilder
     */
    public function whereCity(string $city): self
    {
        return $this->whereIn('hotel_id', function ($q) use ($city) {
            $q->select('hotel_id')
                ->from('addresses')
                ->whereRaw('LOWER(`city`) = ?', trim(strtolower($city)));
        });
    }

    public function whereArea(string $area): self
    {        
        return $this->whereIn('hotel_id', function ($q) use ($area) {            
            $q->select('hotel_id')
                ->from('addresses')
                ->whereRaw('LOWER(`city_area`) = ?', trim(strtolower($area)));
        });
    }
    
    public function whereDistrict(string $district): self
    {
        return $this->whereIn('hotel_id', function ($q) use ($district) {
            $q->select('hotel_id')
                ->from('addresses')
                ->whereRaw('LOWER(`city_district`) = ?', trim(strtolower($district)));
        });
    }
}
