<?php

namespace App\Http\Controllers;

use Domain\Search\DataTransferObjects\ParamsData;
use Domain\Room\Actions\CreateBookingFromDataAction;
use Domain\Room\Actions\GenerateBookingMessageAction;
use Domain\Room\DataTransferObjects\BookingData;
use Domain\Room\Jobs\BookRoomJob;
use Domain\Room\Models\Room;
use Domain\Room\Requests\BookingRequest;
use Domain\Room\ViewModels\RoomListViewModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;

class RoomController extends Controller
{
    public function index(Request $request): Response | ResponseFactory
    {
        return Inertia::render('Room/Index', new RoomListViewModel(ParamsData::fromRequest($request)));
    }

    public function booking(BookingRequest $request): RedirectResponse
    {
        $bookingData = BookingData::fromRequest($request);
        $booking = CreateBookingFromDataAction::run($bookingData);
        BookRoomJob::dispatch($bookingData);

        return Redirect::back()->with(['message' => GenerateBookingMessageAction::run($bookingData)]);
    }

    public function hot(Request $request): Response | ResponseFactory
    {
        $paramsData = ParamsData::fromRequest($request);
        $paramsData->rooms->is_hot = true;
        return Inertia::render('Room/Index', new RoomListViewModel($paramsData, '/rooms/hot'));
    }

    //Depricated
    public function hot_(): View
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
     * Получить по api информацию о номере
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function getRoomInfo(int $id): JsonResponse
    {
        $room = Room::where('id', $id)->with(['hotel', 'category'/*, 'costs'*/])->first();

        return \response()->json([
            'room_info' => $room,
            'costs' => $room->costs->pluck('period'),
        ]);
    }
}
