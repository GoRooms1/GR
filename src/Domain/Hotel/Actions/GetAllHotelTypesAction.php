<?php

declare(strict_types=1);

namespace Domain\Hotel\Actions;


use Domain\Hotel\Models\HotelType;
use Lorisleiva\Actions\Action;
use Illuminate\Database\Eloquent\Collection;

/**
 * @method static Collection run()
 */
final class GetAllHotelTypesAction extends Action
{
    public function handle(): Collection
    {
        return HotelType::without('hotels')->orderBy('sort')->get();
    }
}
