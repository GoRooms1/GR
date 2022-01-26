<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\AttributeCategory;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use Intervention\Image\Exception\NotFoundException;

class AttributeCategoriesController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return Application|Factory|View
   */
  public function index()
  {
    $c_attrs = AttributeCategory::all();
    return view('admin.attribute_categories.index', compact('c_attrs'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Application|Factory|View
   */
  public function create()
  {
    $model_translate = Attribute::MODELS_TRANSLATE;
    return view('admin.attribute_categories.create', compact('model_translate'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   *
   * @return RedirectResponse
   */
  public function store(Request $request): RedirectResponse
  {
    $request->validate([
      'name' => 'required|string|min:3|unique:attribute_categories',
      'description' => 'sometimes|nullable|string|max:255',
    ]);

    $c = AttributeCategory::create($request->all());
    $c->save();

    return redirect()->route('admin.attribute_categories.index')->with('success', 'Категория атрибутов успешно создана');

  }

  /**
   * Display the specified resource.
   *
   * @param int $id
   *
   * @return Application|Factory|RedirectResponse|View
   */
  public function show(int $id, Request $request)
  {
    try {
      $c = AttributeCategory::findOrFail($id);
      if ($request->get('hotel', null)) {
        $attributes = $c->attributes()->forHotels()->get();
      } else if ($request->get('room', null)) {
        $attributes = $c->attributes()->forRooms()->get();
      } else {
        $attributes = $c->attributes;
      }

      return view('admin.attribute_categories.show', compact('c', 'attributes'));
    } catch (NotFoundException $e) {
      return redirect()->route('admin.attribute_categories.index')->withErrors('Категория не была найдена');
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param int $id
   *
   * @return Application|Factory|View|RedirectResponse
   */
  public function edit(int $id)
  {
    try {
      $c = AttributeCategory::findOrFail($id);
      return view('admin.attribute_categories.edit', compact('c'));
    } catch (NotFoundException $e) {
      return redirect()->back()->withErrors('Категория не была найдена');
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param int     $id
   *
   * @return RedirectResponse
   */
  public function update(Request $request, int $id): RedirectResponse
  {
    $request->validate([
      'name' => 'required|string|min:3|unique:attribute_categories,name,' . $id,
      'description' => 'sometimes|nullable|string|max:255',
    ]);

    try {
      $c = AttributeCategory::findOrFail($id);
      $c->update($request->all());

      return redirect()->route('admin.attribute_categories.index')->with('success', 'Категория атрибутов успешно изменена');
    } catch (NotFoundException $e) {
      return redirect()->back()->withErrors('Категория не была найдена');
    }

  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   *
   * @return RedirectResponse
   */
  public function destroy(int $id): RedirectResponse
  {
    try {
      $category_attr = AttributeCategory::findOrFail($id);

      if ($category_attr->attributes()->count() > 0) {
        return redirect()->back()->withErrors('В данной категории имеются атрибуты');
      }

      $category_attr->delete();

      return redirect()->back()->with('success', 'Категория была удалена');
    } catch (NotFoundException $e) {
      return redirect()->back()->withErrors('Категория не была найдена');
    }

  }
}
