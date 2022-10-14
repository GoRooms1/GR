<?php

declare(strict_types=1);

namespace App\Transformers;

final class StreetData extends \Spatie\DataTransferObject\DataTransferObject
{
    public int $id;

    public string $name;

    public string $city;

    public ?string $area;

    public ?string $district;
}
