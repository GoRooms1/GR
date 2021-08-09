<?php

namespace App\Http\Controllers;

use App\Events\FormSend;
use App\Models\Form;
use App\Models\FormEvent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FormController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $form = new Form();
        $form->page = url()->previous();
        $form->ip = $request->ip();
        $form->fields = json_encode($request->except(['_token']));
        $form->save();

        event(new FormSend($form));

        return redirect()->back()->with(['showSuccessModal' => true]);
    }
}
