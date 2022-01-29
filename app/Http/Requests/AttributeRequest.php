<?php

namespace App\Http\Requests;

use App\Models\Attribute;
use Illuminate\Foundation\Http\FormRequest;

class AttributeRequest extends FormRequest
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
  public function rules(): array
  {
    $array = [
      'name' => ['required', 'string', 'max:255'],
      'description' => ['nullable', 'string'],
      'in_filter' => ['required', 'boolean'],
      'category' => ['required', 'exists:attribute_categories,id'],
    ];

    if ($this->method() === 'PUT') {
      return $array;
    }

    $array['model'] = ['required', 'in:' . implode(',', array_keys(Attribute::MODELS_TRANSLATE))];
    return $array;
  }
}
