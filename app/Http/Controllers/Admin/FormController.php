<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FormController extends Controller
{
    public function index(): View
    {
        $forms = Form::all();
        return view('admin.forms.index', compact('forms'));
    }

    public function show(Form $form): View
    {
        return view('admin.forms.show', compact('form'));
    }
}
