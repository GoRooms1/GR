<?php

namespace App\Http\Controllers\Render;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoomController extends Controller
{
    public function index(): View
    {
        $rooms = Room::paginate(20);
        return view('render.room.index', compact('rooms'));
    }

    public function hot(): View
    {
        $rooms = Room::hot()->paginate(30);
        return view('render.room.index', compact('rooms'));
    }
}
