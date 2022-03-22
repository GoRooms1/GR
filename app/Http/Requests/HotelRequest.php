<?php

namespace App\Http\Requests;

use App\Models\Metro;
use Illuminate\Foundation\Http\FormRequest;

class HotelRequest extends FormRequest
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
        $id = $this->has('hotel') ? $this->get('hotel') : 0;
        return [
            'name' => ['required', 'max:255', 'string'],
            'phone' => ['required', 'string'],
            'hide_phone' => ['required', 'boolean'],
            'description' => ['nullable', 'string'],
            'image' => ['array'],
            'image.*' => ['image'],
            'is_popular' => ['boolean', 'nullable'],
            'attributes.*' => ['exists:attributes,id'],
            'cost.*' => ['array'],
            'cost.*.description' => ['string'],
            'cost.*.type_id' => ['numeric', 'exists:cost_types,id'],
            'type_id' => ['numeric', 'exists:hotel_types,id'],
            'route' => ['string', 'nullable'],
            'route_title' => ['string'],
            'metros' => ['array'],
            'metros.*.color' => ['nullable'],
            'metros.*.name' => ['nullable', 'string'],
            'metros.*.distance' => ['nullable', 'string'],
            'address' => ['required', 'string'],
            'address_comment' => ['nullable', 'string'],
            'slug' => ['nullable', 'string', 'unique:hotels,slug'.($id ? ','.$id : '')],
            'email' => ['nullable', 'email'],
        ];
    }
}
