<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Lorisleiva\Actions\Action;

/**
 * @method static string run()
 */
final class GenerateRoomsRandomSortAction extends Action
{   
    public function handle(): string
    {
        $columns = ['name', 'number', 'order', 'category_id', 'hotel_id'];
        $directions = ['asc', 'desc'];
        $sort = $columns[array_rand($columns,1)].','.$directions[array_rand($directions,1)];

        return $sort;
    }
}
