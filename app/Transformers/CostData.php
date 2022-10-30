<?php

declare(strict_types=1);

namespace App\Transformers;

use Domain\Room\Models\CostType;

final class CostData extends \Spatie\DataTransferObject\DataTransferObject
{
    public CostType $type;

    public string $value;
}
