<?php

namespace App\Http\Controllers\Lk;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
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
}