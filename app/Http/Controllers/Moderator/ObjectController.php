<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

namespace App\Http\Controllers\Moderator;

use App\Models\Hotel;
use App\Models\Metro;
use Illuminate\View\View;
use App\Models\Attribute;
use App\Models\HotelType;
use Illuminate\Http\Request;
use App\Models\AttributeCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Http\Requests\LK\ObjectUpdateRequest;
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
  public function edit (int $id)
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

      return view('moderator.object.edit', compact('hotel', 'attributes', 'attributeCategories', 'hotelTypes'));
    } catch (ModelNotFoundException $e) {
      abort('404', 'Отель с таким индексом не найден');
    }
  }

  /**
   * @param int                 $id
   * @param ObjectUpdateRequest $request
   *
   * @return RedirectResponse
   */
  public function update(int $id, ObjectUpdateRequest $request): RedirectResponse
  {
    $hotel = Hotel::findOrFail($id);
    $type = $request->get('type_update');

    if ($hotel) {
      if ($type === 'phone' || $type === 'description') {
        $hotel->update($request->all());
      } else if ($type === 'address') {
        $hotel->saveAddress($request->get('value'), $request->get('comment'));
      } else if ($type === 'metros') {
        $hotel->metros()->delete();
        $distance = $request->get('metros_time');
        $color = $request->get('metros_color');
        foreach ($request->get('metros', []) as $index => $metro) {
          $metros = [
            'name'     => $metro,
            'hotel_id' => $hotel->id,
            'distance' => $distance[$index],
            'color'    => $color[$index]
          ];
          Metro::create($metros);
        }
      } else if ($type === 'attr') {
        $attr = [];
        foreach ($request->get('attr') as $item => $value) {
          if ($value === 'true') {
            $attr[] = $item;
          }
        }

        $hotel->attrs()->sync($attr);
      }
    }

    return redirect()->back()->with('success', 'Данные отеля обновились');
  }

}