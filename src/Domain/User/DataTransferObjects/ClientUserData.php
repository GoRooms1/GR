<?php

declare(strict_types=1);

namespace Domain\User\DataTransferObjects;

use App\User;
use DateTime;
use Domain\User\ValueObjects\ClientsPhoneNumberValueObject;
use Illuminate\Support\Carbon;


final class ClientUserData extends \Parent\DataTransferObjects\Data
{
    public function __construct(        
        public string $name,
        public ?string $phone,
        public ?string $phone_hidden,
        public ?string $email,
        public ?string $gender,
        public bool $email_verified,
        public bool $need_change_password,
        public bool $notify_hot,
        public bool $notify_review,
        public ?Carbon $verification_sent_at,
        public bool $can_resend_verification,
    ) {
    }

    public static function fromModel(User $user): self
    {        
        $phone = new ClientsPhoneNumberValueObject($user->phone);
        $email = filter_var($user->email, FILTER_VALIDATE_EMAIL) ? $user->email : null;
        return self::from([
            'name' => $user->name,            
            'phone' => $phone->toDisplayValue(),
            'phone_hidden' => $phone->toHiddenDisplayValue(),
            'email' => $email,
            'gender' => $user->gender,
            'email_verified' => $user->hasVerifiedEmail(),
            'need_change_password' => !empty($user->code) && password_verify($user->code, $user->password),
            'notify_hot' => $user->notify_hot,
            'notify_review' => $user->notify_review,
            'verification_sent_at' => $user->verification_sent_at,
            'can_resend_verification' => $user->verification_sent_at == null || $user->verification_sent_at->addMinutes(60)->lte(Carbon::now()),
        ]);
    }
}
