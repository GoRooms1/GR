<?php
declare(strict_types=1);

namespace Domain\Feedback\DataTransferObjects;

final class FeedbackData extends \Parent\DataTransferObjects\Data
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $phone,
        public readonly string $message,
    )
    {
    }

    public static function rules(): array
    {
        return [
            'name' => [
                'required', 'string', 'min:3', 'max:190'
            ],
            'email' => [
                'required', 'email'
            ],
            'phone' => [
                'required', 'phone:RU'
            ],
            'message' => [
                'required', 'string', 'min:5'
            ]
        ];
    }
}