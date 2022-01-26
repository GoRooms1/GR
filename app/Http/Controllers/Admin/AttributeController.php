<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attribute;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
  public function index(): View
  {
    $attributes = Attribute::all();
    return view('admin.attributes.index', compact('attributes'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create(): View
  {
    return view('admin.attributes.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   *
   * @return Response
   */
  public function store(AttributeRequest $request): RedirectResponse
  {
    $validated = $request->validated();
    $attribute = Attribute::create($validated);
    return redirect()->route('admin.attributes.index', $attribute->category)->with('success', true);
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
   * @return Response
   */
  public function edit(Attribute $attribute): View
  {
    return view('admin.attributes.edit', compact('attribute'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request   $request
   * @param Attribute $attribute
   *
   * @return Response
   */
  public function update(AttributeRequest $request, Attribute $attribute): RedirectResponse
  {
    $validated = $request->validated();
    $attribute->fill($validated);
    $attribute->save();
    return redirect()->route('admin.attributes.index', $attribute->category);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param Attribute $attribute
   *
   * @return Response
   */
  public function destroy(Attribute $attribute): RedirectResponse
  {
    $category = $attribute->category;
    $attribute->delete();
    return redirect()->route('admin.attributes.index', $category);
  }
}
