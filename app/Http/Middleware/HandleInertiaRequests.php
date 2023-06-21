<?php

namespace App\Http\Middleware;

use Domain\Address\Actions\GetAvailibleCitiesCountAction;
use Domain\Address\Actions\GetLocationByIp;
use Domain\Address\Actions\GetLocationFromSession;
use Domain\Hotel\Actions\GetAvailibleHotelsCountAction;
use Domain\Room\Actions\GetAvailibleRoomsCountAction;
use Domain\Settings\Actions\GetContactsSettingsAction;
use Domain\User\Actions\GetLoggedUserModeratorStatusAction;
use Illuminate\Http\Request;
use Inertia\Middleware;
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
        $geoLocation = null;
        $city = $request->get('hotels', [])['city'] ?? null;   
             
        if (is_null($city) && !$isModerator) {
            $geoLocation = GetLocationFromSession::run($request->ip());
            $request->merge([
                'hotels' => [
                    'city' => $geoLocation->city,
                ]
            ]);
        }

        return array_merge(parent::share($request), [            
            'modals' => [],
            'flash' => [
                'message' => fn () => $request->session()->get('message'),
            ],
            'count' => [
                'hotels' => fn() => GetAvailibleHotelsCountAction::run(),
                'rooms' => fn() => GetAvailibleRoomsCountAction::run(),
                'cities' => fn() => GetAvailibleCitiesCountAction::run(),
            ],
            'location' => fn() => GetLocationFromSession::run($request->ip()),
            'contacts' => fn() => GetContactsSettingsAction::run(),
            'path' => Str::start($request->path(), '/'),
            'app_url' => fn() => config('app.url'),
            'is_moderator' => fn() => $isModerator,
            'yandex_api_key' => fn() => config('services.yandex.map.key'),
        ]);
    }
}
