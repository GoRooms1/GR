<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Lorisleiva\Actions\Action;

/**
 * @method static string run(string $start, ?string $end)
 */
final class GenerateInfoDescForPeriod extends Action
{
    public function handle(string $start, ?string $end): string
    {
        if ($end) {
            return $start.' - '.$end;
        }

        return 'От '.$start.GetEndingValue::run((int) $start);
    }
}
