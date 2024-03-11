<?php

namespace Support\Rules;

use App\User;
use Domain\User\ValueObjects\ClientsPhoneNumberValueObject;
use Illuminate\Contracts\Validation\Rule;

class UniqueClientPhone implements Rule
{  
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {       
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {        
        return !User::where('is_client', true)
            ->where('phone', ClientsPhoneNumberValueObject::fromNative($value)->toNative())
            ->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {     
        return __('validation-inline.unique');        
    }
}
