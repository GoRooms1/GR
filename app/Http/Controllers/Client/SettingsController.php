<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\UpdateUserSettingsRequest;
use App\User;
use Domain\User\DataTransferObjects\ClientUserData;
use Hash;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;

class SettingsController extends Controller
{
    public function index(): Response | ResponseFactory
    {       
        $user = User::findOrFail(auth()->user()->id);
        return Inertia::render('Client/Settings', [
            'user' => ClientUserData::fromModel($user),
        ]);
    }

    public function update(UpdateUserSettingsRequest $request)
    {       
        $user = User::find(auth()->user()->id);

        if (!empty(trim($request->get('password', '')))) {
            $user->password = Hash::make($request->get('password'));
        }

        if (!filter_var($user->email, FILTER_VALIDATE_EMAIL) || $request->get('email') !== $user->email) {
            $user->email = $request->get('email');
            $user->email_verified_at = null;
        }

        $user->name = $request->get('name');
        $user->gender = $request->get('gender');
        $user->notify_hot = $request->get('notify_hot', false);
        $user->notify_review = $request->get('notify_review', false);

        $user->save();

        return Redirect::back()->with(['message' => "Данные успешно сохранены!"]);
    }    
}
