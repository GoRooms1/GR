<?php

namespace App\Http\Middleware;

use Cache;
use Domain\Address\Actions\GetAvailibleCitiesCountAction;
use Domain\Hotel\Actions\GetAllHotelTypesAction;
use Domain\Hotel\Actions\GetAvailibleHotelsCountAction;
use Domain\Hotel\DataTransferObjects\HotelTypeKeyNameData;
use Domain\Hotel\Models\HotelType;
use Domain\Room\Actions\GetAvailibleRoomsCountAction;
use Domain\Room\Actions\GetFavoriteRoomsAction;
use Domain\Settings\Actions\GetContactsSettingsAction;
use Domain\User\Actions\GetLoggedUserModeratorStatusAction;
use Domain\User\DataTransferObjects\ClientUserData;
use Illuminate\Http\Request;
use Inertia\Middleware;
use stdClass;
use Str;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {        
        $isModerator = GetLoggedUserModeratorStatusAction::run();
       
        return array_merge(parent::share($request), [            
            'modals' => fn() => (object)[],
            'flash' => [
                'message' => fn () => $request->session()->get('message'),                
            ],
            'count' => [
                'hotels' => fn() => GetAvailibleHotelsCountAction::run(),
                'rooms' => fn() => GetAvailibleRoomsCountAction::run(),
                'cities' => fn() => GetAvailibleCitiesCountAction::run(),
            ],            
            'contacts' => fn() => GetContactsSettingsAction::run(),       
            'app_url' => fn() => $request->root(),
            'path' => rtrim(Str::start($request->path(), '/'), '/'),
            'is_moderator' => fn() => $isModerator,
            'yandex_api_key' => fn() => config('services.yandex.map.key'),      
            'is_loading' => false,
            'auth' => fn() => !is_null(auth()->user()),            
            'user' => fn() => !is_null(auth()->user()) && auth()->user()?->is_client ? (ClientUserData::fromModel(auth()->user())) : null,
            'favorites' => fn() => GetFavoriteRoomsAction::run()->flatten(),
            'hotel_types' => Cache::remember('params_hotel_types', now()->addDays(30), function () {            
                return HotelTypeKeyNameData::collection(GetAllHotelTypesAction::run());
            }),
            'dadata_token' => fn() => config('dadata.token'),
            'dadata_suggest_url' => fn() => config('dadata.suggest_url'),
        ]);
    }
}
