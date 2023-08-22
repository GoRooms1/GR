<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdBannerUpdateRequest extends FormRequest
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
        return [
            'name' => ['required', 'string'],
            'url' => ['nullable', 'url'],
            'email' => ['required', 'email'],
            'cities' => ['nullable', 'array'],
            'show_from' => ['nullable', 'date'],
            'show_to' => ['nullable', 'date'],
            'is_show_always' => ['nullable'],
            'is_show_on_hotels' => ['nullable'],
            'is_show_on_rooms' => ['nullable'],
            'is_show_on_hotel' => ['nullable'], 
            'is_show_on_hot' => ['nullable'],         
        ];
    }
}
