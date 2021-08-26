<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

namespace App\Http\Controllers\Lk;

use Exception;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\LK\CategoryRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
  public function update(CategoryRequest $request): JsonResponse
  {
    $category = Category::findOrFail($request->get('id'));

    if ($this->save($category, $request->all())) {
      return response()->json(['status' => 'success']);
    }

    return response()->json(['status' => 'error']);
  }

  public function create(CategoryRequest $request): JsonResponse
  {
    $category = new Category();

    if ($this->save($category, $request->all())) {
      return response()->json([
        'status' => 'success',
        'category' => $category
      ]);
    }

    return response()->json(['status' => 'error']);
  }

  /**
   * @throws Exception
   */
  public function delete(Category $category): JsonResponse
  {
    $status = $category->delete();
    return response()->json(['status' => (boolean) $status]);
  }

  public function save(&$category, $data): bool
  {
    try {
      $category->name = $data['name'];

      if (isset($data['hotel_id'])) {
        $category->hotel()->associate($data['hotel_id']);
      }

      $category->save();

      return true;
    } catch (Exception $exception) {
      return false;
    }
  }
}
