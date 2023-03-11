<?php

namespace App\Http\Controllers;

use Domain\Feedback\DataTransferObjects\FeedbackData;
use Domain\Feedback\Jobs\SendFeedbackMailJob;
use Domain\Page\Actions\GetContactPageAction;
use Domain\Page\ViewModels\PageDetailViewModel;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;

class ContactController extends Controller
{
    public function index(GetContactPageAction $action): Response | ResponseFactory
    {
        return Inertia::render('Contacts/Index', [
            'model' => new PageDetailViewModel($action->handle()),
        ]);
    }

    public function store(FeedbackData $feedbackData): \Illuminate\Http\RedirectResponse
    {
        SendFeedbackMailJob::dispatch($feedbackData);

        return Redirect::route('contact')->with(['message' => 'Ваше сообщение отправлено и в ближайшее время наши менеджеры свяжуться с вами.']);
    }
}
