<?php

namespace App\Http\Controllers\Moderator;

use App\Models\Hotel;
use App\Http\Controllers\Controller;

class InstructionController extends Controller
{

  public function index (int $id)
  {
    $hotel = Hotel::findOrFail($id);
    return view('moderator.instruction.index', compact('hotel'));
  }

}