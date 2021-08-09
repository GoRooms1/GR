<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'city' => ['required', 'string'],
            'room' => ['nullable', 'string'],
            'text' => ['required', 'string'],
            'rating.*' => ['array'],
            'rating.*.category_id' => ['numeric', 'exists:rating_categories,id'],
            'rating.*.value' => ['numeric', 'min:1', 'max:10'],
        ];
    }
}
