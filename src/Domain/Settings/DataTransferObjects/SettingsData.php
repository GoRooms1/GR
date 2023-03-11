<?php

declare(strict_types=1);

namespace Domain\Settings\DataTransferObjects;

use Domain\Settings\Models\Settings;
use Illuminate\Support\Carbon;

final class SettingsData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?int $id,
        public string $option,
        public string $value,
        public ?string $header,
        public ?Carbon $created_at,
        public ?Carbon $updated_at,
    ) {
    }

    public static function fromModel(Settings $settings): self
    {
        return self::from([
            ...$settings->toArray(),
            'created_at' => $settings->created_at,
            'updated_at' => $settings->updated_at,
        ]);
    }
}
