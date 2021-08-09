<?php

namespace App\Http\Requests;

use App\Rules\ExistWhere;
use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
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
        $costs = $this->get('cost', []);
        $cost_keys = array_keys($costs);
        $cost_first_key = current($cost_keys);

        return [
            'name' => ['required', 'max:255', 'string'],
            'description' => ['nullable', 'string'],
            'hotel_id' => ['required', 'exists:hotels,id', 'integer'],
            'category_id' => [
                'nullable',
                'integer',
                new ExistWhere('categories', 'id', 'hotel_id', $this->hotel_id)
            ],
            'image.*' => ['nullable', 'image'],
            'is_hot' => ['nullable', 'boolean'],
            'attributes' => ['nullable', 'array'],
            'attributes.*' => ['exists:attributes,id', 'nullable'],
            'cost.*' => ['array'],
            'cost.'.$cost_first_key.'.value' => ['numeric', 'required'],
            'cost.'.$cost_first_key.'.description' => ['string', 'required'],
            'cost.*.description' => ['string', 'nullable'],
            'cost.*.value' => ['numeric', 'nullable'],
            'cost.*.type_id' => ['numeric', 'exists:cost_types,id', 'nullable'],
        ];
    }
}
