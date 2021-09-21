<?php
/*
 * Copyright (c) 2021.
 * This code is the property of the Fulliton developer.
 * Write all questions and suggestions on the Vkontakte social network https://vk.com/fulliton
 */

namespace App\Http\Controllers\Lk;

use App\Http\Controllers\Controller;
use App\Models\HotelType;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HomeController extends Controller
{

  /**
   * Index page Personal Area
   *
   * @return Application|Factory|View
   */
  public function index(): View
  {
    return view('lk.index');
  }

  /**
   * Create Object
   *
   * @return RedirectResponse|View
   */
  public function start()
  {
    if (auth()->check() && auth()->user()->personal_hotel) {
      return redirect()->route('lk.index');
    }

    $types = HotelType::all();
    return view('lk.start', compact('types'));
  }
}