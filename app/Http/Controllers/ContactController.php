<?php

namespace App\Http\Controllers;

use Domain\Page\Actions\GetContactPageAction;
use Domain\Page\ViewModels\PageDetailViewModel;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;

class ContactController extends Controller
{
    public function show(GetContactPageAction $action): Response | ResponseFactory
    {
        return Inertia::render('Content/Contact', [
            'model' => new PageDetailViewModel($action->handle()),
        ]);
    }
}
