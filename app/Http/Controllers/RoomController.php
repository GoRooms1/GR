<?php

namespace App\Http\Controllers;

use App\Jobs\BookRoomJob;
use App\Models\Booking;
use App\Models\Form;
use Carbon\Carbon;
use Domain\Filter\DataTransferObjects\ParamsData;
use Domain\Room\Models\Room;
use Domain\Room\ViewModels\RoomListViewModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

    //Depricated
    public function index_(): View
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
     * @param  int  $id
     * @param  Request  $request
     * @return RedirectResponse
     *
     * @throws \JsonException
     */
    public function booking(int $id, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'book-name' => ['required', 'string'],
            'book-tel' => ['required', 'string'],
            'from-date' => ['required', 'date'],
            'from-time' => ['required', 'string'],
            'to-date' => ['required', 'date'],
            'to-time' => ['required', 'string'],
            'book-comment' => ['nullable'],
            'book_by' => ['string'],
            'order_at' => ['string'],
        ]);

        //todo form - это то, где раньше хранились заказы (и остаются лежать старый заказы), скорее всего это надо будет удалить
        $form = new Form();
        $form->page = url()->previous();
        $form->ip = $request->ip();
        $form->fields = json_encode($validated, JSON_THROW_ON_ERROR);
        $form->save();

        $validated['book_number'] = BookingController::defineNextBookNumber();
        $booking = Booking::create([
            'book_number' => $validated['book_number'],
            'client_fio' => $validated['book-name'],
            'client_phone' => $validated['book-tel'],
            'book_type' => $validated['order_at'],
            'book_comment' => $validated['book-comment'],
            'from-date' => Carbon::createFromFormat('Y-m-d H:m', $validated['from-date'].' '.$validated['from-time'])->toDateTimeString(),
            'to-date' => ($validated['order_at'] !== 'hour'
                && $validated['order_at'] !== 'night')
                ? Carbon::createFromFormat('Y-m-d H:m', $validated['to-date'].' '.$validated['to-time'])->toDateTimeString()
                : null,
            'hours_count' => $validated['order_at'] === 'hour' ?
              $validated['book_by']
              : null,
        ]);
        $booking->room()->associate($id);
        $booking->save();

        BookRoomJob::dispatch($id, $validated);
        /** @var Room $room */
        $room = Room::where('id', $id)->with(['hotel', 'category'/*, 'costs'*/])->first();

        $message = 'Бронирование № '.$validated['book_number'].'<br><br>';
        $label = $room->name ?? $room->id;
        $message .= 'Вы совершили бронирование в номере<br>'.$label;
        $message .= $room->category_id ? ' , в категории "'.$room->category->name.'"' : '';
        $message .= '<br>в объекте размещения: "'.$room->hotel->type->single_name.': '.$room->hotel->name.'".';
        $message .= '';
        $message .= '<br>Администратор '.$room->hotel->name.' свяжется с Вами в случае необходимости!
                    <br>Ждем Вас и приятного отдыха!';

        return redirect()->back()->with([
            'showSuccessModal' => true,
            'SuccessModalMessage' => $message,
        ]);
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
