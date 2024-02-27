<?php

namespace App\Http\Requests\Moderate;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReviewRequest extends FormRequest
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
            'photo' => ['nullable', 'image', 'max:102400'],
            'rating' => ['array'],            
            'rating.*' => ['numeric', 'min:1', 'max:10'],
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
