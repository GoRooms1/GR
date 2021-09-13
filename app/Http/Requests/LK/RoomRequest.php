<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

namespace App\Http\Requests\LK;

use App\Models\Hotel;
use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules(): array
  {
    $id = $this->get('id');

    $hotel = Hotel::whereHas('rooms', function ($q) use($id) {
      $q->where('id', $id);
    })->firstOrFail();

    $hotel_id = $hotel->id;

    if ($hotel->type_fond === Hotel::CATEGORIES_TYPE) {
      return [
        'id' => 'required', 'exists:room,id',
        'category' => 'required', 'exists:categories,id',
        'types' => 'required', 'array',
        'types.*.id' =>'required', 'exists:cost_types,id',
        'types.*.value' =>'required',
        'types.*.data' =>'required', 'exists:periods,id',
      ];
    }

    return [
      'order' => 'sometimes', 'required', 'unique:rooms,order,'. $id .',id,hotel_id,' . $hotel_id,
      'number' => 'sometimes', 'required',
      'name' => 'sometimes', 'required',
      'category' => 'sometimes', 'required', 'exists:categories,id',
      'types' => 'sometimes', 'required', 'array',
      'types.*.id' =>'required', 'exists:cost_types,id',
      'types.*.value' =>'required',
      'types.*.data' =>'required', 'exists:periods,id',
    ];
  }
}
