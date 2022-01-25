<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

namespace App\Http\Requests\LK;

use App\Models\Metro;
use Illuminate\Foundation\Http\FormRequest;

class ObjectUpdateRequest extends FormRequest
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
      'type_update' => ['required', 'string'],
      'phone' => ['sometimes', 'required', 'string'],
      'phone_2' => ['sometimes', 'nullable', 'string'],
      'description' => ['sometimes', 'nullable', 'string'],
      'attr' => ['sometimes', 'array'],
      'attr.*' => ['sometimes', 'required', 'exists:attributes,id'],
      'comment' => ['sometimes', 'nullable', 'string'],
      'email' => ['sometimes', 'nullable', 'email'],
      'metros' => ['sometimes', 'min:0', 'array'],
      'metros_time' => ['sometimes', 'min:0', 'array'],
      'metros_color' => ['sometimes', 'min:0', 'array'],
      'route' => ['sometimes', 'required', 'string'],
    ];
  }
}
