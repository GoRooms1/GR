<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Instruction;

class InstructionController extends Controller
{
    public function index(int $id)
    {
        $hotel = Hotel::findOrFail($id);
        $instructions = Instruction::all();

        return view('moderator.instruction.index', compact('hotel', 'instructions'));
    }
}
