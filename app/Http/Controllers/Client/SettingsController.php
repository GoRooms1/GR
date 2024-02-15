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
use Request;

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

        if (!filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
            $user->email = $request->get('email');
        }

        $user->name = $request->get('name');
        $user->gender = $request->get('gender');
        $user->notify_hot = $request->get('notify_hot', false);
        $user->notify_review = $request->get('notify_review', false);

        $user->save();

        return Redirect::back()->with(['message' => "Данные успешно сохранены!"]);
    }

    public function delete(Request $request)
    {       
        $user = User::find(auth()->user()->id);

        return Redirect::back()->with([
            'message' => "Вам на почту отправлено письмо со ссылкой, пройдя по которой Ваш аккаунт будем полностью удален. Спасибо."
        ]);
    }

    public function verifyDelete(Request $request, int $id, string $hash)
    {
        return Redirect::route('home');
    }
}
