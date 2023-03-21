<?php

declare(strict_types=1);

namespace Domain\Filter\DataTransferObjects;

use Illuminate\Http\Request;

/**
 * Summary of RoomParamsData
 */
final class RoomParamsData extends \Parent\DataTransferObjects\Data
{
    /**
     * @param  array<int>|null  $attributes
     * @param  bool|null  $is_hot
     * @param  bool|null  $low_cost
     */
    public function __construct(
        public ?array $attributes,
        public ?bool $is_hot,
        public ?bool $low_cost,
        public ?string $period_cost,
    ) {
    }

    /**
     * @param  Request  $request
     * @return RoomParamsData
     */
    public static function fromRequest(Request $request): self
    {
        /** @var array<string, array<int>|string|int|bool|null> $data */
        $data = $request->get('rooms', []);

        return self::from([
            'attributes' => $data['attributes'] ?? [],
            'is_hot' => isset($data['is_hot']) ? filter_var($data['is_hot'], FILTER_VALIDATE_BOOLEAN) : null,
            'low_cost' => isset($data['low_cost']) ? filter_var($data['low_cost'], FILTER_VALIDATE_BOOLEAN) : null,
            'period_cost' => $data['period_cost'] ?? null,
        ]);
    }
}
