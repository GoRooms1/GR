<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Hash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ModeratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        $users = User::whereIsModerate(true)->get();

        return view('admin.moderators.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        return view('admin.moderators.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate(['name' => 'required|string', 'email' => 'required|unique:users,email', 'password' => 'required|string', 'phone' => 'required|string']);

        $user = User::create($request->all());
        $user->password = Hash::make($request->get('password'));
        $user->is_moderate = true;
        $user->save();

        return redirect()->route('admin.moderators.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function edit(int $id)
    {
        $user = User::findOrFail($id);

        return view('admin.moderators.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate(['name' => 'required|string', 'email' => 'required|unique:users,email,'.$id, 'password' => 'sometimes', 'phone' => 'required|string']);
        $user = User::findOrFail($id);

        $user->update($request->except('password'));

        if ($request->has('password') && $request->get('password') !== '') {
            $user->password = Hash::make($request->get('password'));
        }
        $user->save();

        return redirect()->route('admin.moderators.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     *
     * @throws \Exception
     */
    public function destroy(int $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->forceDelete();

        return redirect()->route('admin.moderators.index');
    }
}
