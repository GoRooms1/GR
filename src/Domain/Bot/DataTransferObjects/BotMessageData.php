<?php

declare(strict_types=1);

namespace Domain\Bot\DataTransferObjects;

final class BotMessageData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public int $chat_id,
        public ?string $text,
        public string $parse_mode = 'html',
    ) {
    }
}
