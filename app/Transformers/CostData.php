<?php

declare(strict_types=1);

namespace App\Transformers;

use App\Models\CostType;

final class CostData extends \Spatie\DataTransferObject\DataTransferObject
{
    public CostType $type;

    public string $value;
}
