<?php

declare(strict_types=1);

namespace Domain\User\DataTransferObjects;

use App\User;
use Domain\User\ValueObjects\ClientsPhoneNumberValueObject;
use Illuminate\Support\Carbon;


final class ClientUserData extends \Parent\DataTransferObjects\Data
{
    public function __construct(        
        public string $name,
        public ?string $phone,
        public ?string $email,
        public ?string $gender,
        public bool $email_verified,
        public bool $need_change_password,
        public bool $notify_hot,
        public bool $notify_review,
    ) {
    }

    public static function fromModel(User $user): self
    {
        $phone = new ClientsPhoneNumberValueObject($user->phone);
        $email = filter_var($user->email, FILTER_VALIDATE_EMAIL) ? $user->email : null;
        return self::from([
            'name' => $user->name,
            'phone' => $phone->toHiddenDisplayValue(),
            'email' => $email,
            'gender' => $user->gender,
            'email_verified' => $user->email_verified_at != null,
            'need_change_password' => !empty($user->code) && password_verify($user->code, $user->password),
            'notify_hot' => $user->notify_hot,
            'notify_review' => $user->notify_review,
        ]);
    }
}
