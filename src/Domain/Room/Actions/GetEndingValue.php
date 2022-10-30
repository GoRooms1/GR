<?php

declare(strict_types=1);

namespace Domain\Room\Actions;

use Lorisleiva\Actions\Action;

/**
 * Русское окончание при сокращениие цифрами до 20 часов
 *
 * @method static string run(int $value)
 */
final class GetEndingValue extends Action
{
    public function handle(int $value): string
    {
        if ($value < 2) {
            return '-го часа';
        }

        if ($value < 5) {
            return '-x часов';
        }

        if ($value < 20) {
            return '-и часов';
        }

        return '';
    }
}
