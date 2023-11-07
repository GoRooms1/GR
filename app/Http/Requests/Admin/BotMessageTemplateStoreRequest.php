<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BotMessageTemplateStoreRequest extends FormRequest
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
            'header' => ['nullable', 'string'],
            'body' => ['nullable', 'string'],
            'url' => ['nullable', 'url'],
            'sort' => ['required', 'integer', 'min:1'],
            'is_active' => ['nullable'],
            'image' => ['nullable', 'image'],
        ];
    }
}
