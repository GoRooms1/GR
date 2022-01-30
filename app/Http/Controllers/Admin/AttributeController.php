<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attribute;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\AttributeCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\AttributeRequest;

class AttributeController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return View
   */
  public function index(Request $request): View
  {

    $attributes = Attribute::query();

    if ($request->get('hotel', null)) {
      $attributes = $attributes->forHotels();
    } else if ($request->get('room', null)) {
      $attributes = $attributes->forRooms();
    }

    if ($request->get('category', null)) {
      $attributes = $attributes->whereHas('relationCategory', function ($q) use ($request) {
        $q->where('id', $request->get('category'));
      });
    }

    $attributes = $attributes->get();

    $categories = AttributeCategory::all();
    return view('admin.attributes.index', compact('attributes', 'categories'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return View
   */
  public function create(): View
  {
    $categories = AttributeCategory::all();
    return view('admin.attributes.create', compact('categories'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param AttributeRequest $request
   *
   * @return RedirectResponse
   */
  public function store(AttributeRequest $request): RedirectResponse
  {
//    dd($request->all());
    $attribute = new Attribute($request->all());
    $attribute->relationCategory()->associate($request->get('category'));
    $attribute->save();
    return redirect()->route('admin.attributes.index')->with('success', 'Атрибут "' . $attribute->name . '" успешно создан');
  }

  /**
   * Display the specified resource.
   *
   * @param Attribute $attribute
   *
   * @return Response
   */
  public function show(Attribute $attribute): View
  {
    return view('admin.attributes.show', compact('attribute'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param Attribute $attribute
   *
   * @return View
   */
  public function edit(Attribute $attribute): View
  {
    $categories = AttributeCategory::all();
    return view('admin.attributes.edit', compact('attribute', 'categories'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param AttributeRequest $request
   * @param Attribute        $attribute
   *
   * @return RedirectResponse
   */
  public function update(AttributeRequest $request, Attribute $attribute): RedirectResponse
  {
    $attribute->update($request->all());
    $attribute->relationCategory()->associate($request->get('category'));
    $attribute->save();
    return redirect()->route('admin.attributes.index')->with('success', 'Атрибут "' . $attribute->name . '" успешно обновлён');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param Attribute $attribute
   *
   * @return RedirectResponse
   */
  public function destroy(Attribute $attribute): RedirectResponse
  {
    $attribute->delete();
    return redirect()->back()->with('success', 'Утрибут успешно удалён');
  }
}
