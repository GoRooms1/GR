<?php

declare(strict_types=1);

namespace Domain\Bot\DataTransferObjects;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

final class BotMessageTemplateData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public ?int $id,
        public string $name,
        public ?string $header,
        public ?string $body,
        public ?string $url,
        public int $frequency,
        public bool $is_active,
    ) {
    }

    public static function fromRequest(FormRequest $request): self
    {
        return self::from([
            'name' => $request->get('name'),
            'header' => $request->get('header'),
            'body' => $request->get('body'),
            'url' => $request->get('url'),
            'frequency' => $request->get('frequency', 1),
            'is_active' => $request->boolean('is_active'),
        ]);
    }
}
