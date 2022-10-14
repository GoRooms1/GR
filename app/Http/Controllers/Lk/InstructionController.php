<?php

namespace App\Http\Controllers\Lk;

use App\Http\Controllers\Controller;
use App\Models\Instruction;

class InstructionController extends Controller
{
    public function index()
    {
        $instructions = Instruction::all();

        return view('lk.instruction.index', compact('instructions'));
    }
}
