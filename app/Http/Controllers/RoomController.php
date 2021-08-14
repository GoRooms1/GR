<?php

namespace App\Http\Controllers;

use App\Jobs\BookRoomJob;
use App\Models\Form;
use App\Models\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class RoomController extends Controller
{

    public function index(): View
    {
        $rooms = Room::paginate(20);
        $hide_filter = false;

        return view('room.index', compact('rooms', 'hide_filter'));
    }

    public function hot(): View
    {
        $rooms = Room::hot()->paginate(30);
        $title = 'Горящие предложения';
        $hide_filter = true;
        return view('room.index', compact('rooms', 'title', 'hide_filter'));
    }

    public function show(Room $room): View
    {
        $pageAbout = $room->meta;
        return view('room.show', compact('room', 'pageAbout'));
    }

    /**
     * Забронировать номер
     *
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function booking(int $id, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'book-name' => ['required', 'string',],
            'book-tel' => ['required', 'string',],
            'book-email' => ['nullable', 'email',],
            'from-date' => ['required', 'date',],
            'from-time' => ['required', 'string',],
            'to-date' => ['required', 'date',],
            'to-time' => ['required', 'string'],
            'book-comment' => ['nullable'],
        ]);
        $form = new Form();
        $form->page = url()->previous();
        $form->ip = $request->ip();
        $form->fields = json_encode($validated);
        $form->save();
        BookRoomJob::dispatch($id, $validated);
        return redirect()->back()->with(['showSuccessModal' => true]);
    }

    /**
     * Получить по api информацию о номере
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getRoomInfo(int $id): JsonResponse
    {
        return \response()->json(['room_info' => Room::where('id', $id)->with(['hotel', 'category'/*, 'costs'*/])->first()]);
    }
}
