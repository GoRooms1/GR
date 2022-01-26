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
   * @return Response
   */
  public function create()
  {
    $model_translate = Attribute::MODELS_TRANSLATE;

    
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   *
   * @return Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param int $id
   *
   * @return Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param int $id
   *
   * @return Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param int     $id
   *
   * @return Response
   */
  public function update(Request $request, $id)
  {
    //
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
