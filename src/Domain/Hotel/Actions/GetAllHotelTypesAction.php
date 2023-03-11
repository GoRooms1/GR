<?php

declare(strict_types=1);

namespace Domain\Hotel\Actions;

use Domain\Hotel\Models\HotelType;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Action;

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
