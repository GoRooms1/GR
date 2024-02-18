<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class CreateReviewRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:3', 'max:191'],            
            'comment' => ['required', 'string', 'min:5','max:1024'],
            'booking_id' => ['required', 'int', 'exists:bookings,id'],
            'photo' => ['required', 'mimes:png,jpg,jpeg,gif', 'max:102400'],
            'rating.*' => ['array'],
            'rating.*.id' => ['numeric', 'exists:rating_categories,id'],
            'rating.*.value' => ['numeric', 'min:1', 'max:10'],
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'photo.required' => 'Необходимо загрузить фотографию',
        ];
    }
}
