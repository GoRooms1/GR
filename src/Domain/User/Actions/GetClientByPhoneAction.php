<?php

declare(strict_types=1);

namespace Domain\User\Actions;

use App\User;
use Domain\User\ValueObjects\ClientsPhoneNumberValueObject;
use Parent\Actions\Action;

/**
 * @method static \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null run(string $phone)
 */
final class GetClientByPhoneAction extends Action
{   
    public function handle(string $phone): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
    {
        return User::where('is_client', true)
            ->where('phone', ClientsPhoneNumberValueObject::fromNative($phone)->toNative())
            ->first();
    }
}
