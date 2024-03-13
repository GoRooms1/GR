<?php

namespace App\Http\Requests\Client;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = User::find(auth()->user()->id);
        $rules = [
            'name' => ['required', 'string', 'max:255'],            
            'gender' => ['required', 'string', 'in:m,f'],
        ];

        if (!filter_var($user->email, FILTER_VALIDATE_EMAIL) || $this->get('email') !== $user->email) {
            $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:users'];
        }

        if ($this->get('password', false) || $this->get('password_confirmation', false)) {
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }

        return $rules;
    }
}
