<?php

namespace App\Http\Controllers\Lk;

use App\Http\Controllers\Controller;

class InstructionController extends Controller
{

  public function index ()
  {
    return view('lk.instruction.index');
  }

}