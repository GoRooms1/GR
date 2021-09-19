<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

namespace App\Http\Controllers\Moderator;

use App\Models\Hotel;
use Illuminate\View\View;
use App\Models\Attribute;
use App\Models\HotelType;
use App\Models\AttributeCategory;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Rewrite Hotel
 */
class ObjectController extends Controller
{

  /**
   * @param int $id
   *
   * @return Application|Factory|View|void
   * @throws ModelNotFoundException
   */
  public function show (int $id)
  {
    try {
      $hotel = Hotel::findOrFail($id);

      $attributes = Attribute::where('model', Hotel::class)
        ->orWhereNull('model')->get();
      $hotelTypes = HotelType::orderBy('sort')
        ->get();
      $attributeCategories = AttributeCategory::with(['attributes' => function ($q) {
        $q->whereModel(Hotel::class)->get();
      }])
        ->get();

      return view('lk.object.edit', compact('hotel', 'attributes', 'attributeCategories', 'hotelTypes'));
    } catch (ModelNotFoundException $e) {
      abort('404', 'Отель с таким индексом не найден');
    }
  }

}