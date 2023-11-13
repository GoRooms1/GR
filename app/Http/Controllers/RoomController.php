<?php

namespace App\Http\Controllers;

use Domain\Address\Actions\GetRegionalCenterByIpAction;
use Domain\Object\ViewModels\ObjectsViewModel;
use Domain\Search\DataTransferObjects\ParamsData;
use Domain\Room\Actions\CreateBookingFromDataAction;
use Domain\Room\Actions\GenerateBookingMessageAction;
use Domain\Room\DataTransferObjects\BookingData;
use Domain\Room\Jobs\BookRoomJob;
use Domain\Room\Requests\BookingRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;

class RoomController extends Controller
{
    public function index(Request $request): Response | ResponseFactory
    {
        $params = ParamsData::fromRequest($request);
        if (!$params->filter) {
            $params->hotels->city = 'Москва';
            $params->room_filter = true;           
        }

        return Inertia::render('Objects/Index', new ObjectsViewModel($params, '/rooms'));
    }

    public function booking(BookingRequest $request): RedirectResponse
    {
        $bookingData = BookingData::fromRequest($request);
        $booking = CreateBookingFromDataAction::run($bookingData);
        BookRoomJob::dispatchSync($bookingData);

        return Redirect::back()->with(['message' => GenerateBookingMessageAction::run($bookingData)]);
    }

    public function hot(Request $request): Response | ResponseFactory
    {
        $params = ParamsData::fromRequest($request);        

        if (!$params->filter) {           
            $params->rooms->is_hot = true;
            $params->room_filter = true;

            if (empty($params->hotels->city)) {
                $params->hotels->city = GetRegionalCenterByIpAction::run($request->ip());
            }
        }

        return Inertia::render('Objects/Index', new ObjectsViewModel($params, '/hot'));
    }
}
