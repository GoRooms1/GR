<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

namespace App\Http\Requests\LK;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
    return [
      'id' => [
        'sometimes',
        'required',
        'exists:categories,id'
      ],
      'name' => [
        'sometimes',
        'required',
        'string',
        'max:255',
        'unique:categories,name,' . $this->get('id') . ',id,hotel_id,' . $this->get('hotel_id'),
      ],
      'value' => [
        'nullable',
        'sometimes',
        'integer',
        'min:0',
      ]
    ];
  }
}
