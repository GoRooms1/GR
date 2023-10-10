<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BotMessageTemplateSendTestRequest;
use App\Http\Requests\Admin\BotMessageTemplateStoreRequest;
use App\Http\Requests\Admin\BotMessageTemplateUpdateRequest;
use App\User;
use Domain\Bot\Actions\GenerateTextFromTemplateAction;
use Domain\Bot\Actions\GetSubscribedUsersOnHotelAction;
use Domain\Bot\Actions\UpdateTemplateCountersAction;
use Domain\Bot\DataTransferObjects\BotMessageData;
use Domain\Bot\DataTransferObjects\BotMessageTemplateData;
use Domain\Bot\Jobs\BotNotificationJob;
use Domain\Bot\Models\BotMessageTemplate;
use Domain\Hotel\Models\Hotel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotMessageTemplateController extends Controller
{
    public function index(): View
    {
        $botMessageTemplates = BotMessageTemplate::all();

        return view('admin.bot_message_templates.index', compact('botMessageTemplates'));
    }

    public function create(): View
    {
        return view('admin.bot_message_templates.create');
    }

    public function store(BotMessageTemplateStoreRequest $request): RedirectResponse
    {
        $data = BotMessageTemplateData::fromRequest($request);
        $botMessageTemplate = BotMessageTemplate::create($data->toArray());
        
        if ($request->file('image')) {
            $botMessageTemplate->clearMediaCollection('images');
            $botMessageTemplate->addFromMediaLibraryRequest('image')
                ->toMediaCollection('images');
        }

        return redirect()->route('admin.bot_message_templates.edit', $botMessageTemplate)->with('success', $botMessageTemplate->id);
    }

    public function edit(BotMessageTemplate $botMessageTemplate): View
    {
        return view('admin.bot_message_templates.edit', compact('botMessageTemplate'));
    }

    public function update(BotMessageTemplateUpdateRequest $request, BotMessageTemplate $botMessageTemplate): RedirectResponse
    {
        $data = BotMessageTemplateData::fromRequest($request);
        $botMessageTemplate->update($data->toArray());
        
        if ($request->file('image')) {
            $botMessageTemplate->clearMediaCollection('images');
            $botMessageTemplate->addMediaFromRequest('image')
                ->toMediaCollection('images');
        }

        return redirect()->route('admin.bot_message_templates.edit', $botMessageTemplate)->with('success', $botMessageTemplate->id);
    }

    public function destroy(BotMessageTemplate $botMessageTemplate): RedirectResponse
    {
        $botMessageTemplate->delete();

        return redirect()->route('admin.bot_message_templates.index');
    }

    public function sendTest(BotMessageTemplateSendTestRequest $request, BotMessageTemplate $botMessageTemplate): RedirectResponse
    {        
        $hotel_id = $request->get('hotel_id');       
        $users = GetSubscribedUsersOnHotelAction::run($hotel_id);
        $text = GenerateTextFromTemplateAction::run($botMessageTemplate);       
        
        foreach ($users as $user) {
            $message = new BotMessageData(
                chat_id: $user->telegram_id,
                text: $text,
                parse_mode: 'markdown',
                disable_web_page_preview: false,
              );
              
            BotNotificationJob::dispatchSync($message);
        }

        UpdateTemplateCountersAction::run($botMessageTemplate, $hotel_id);
        
        return redirect()->route('admin.bot_message_templates.edit', $botMessageTemplate)->with('success', $botMessageTemplate->id);
    }

    public function sendOnetime(BotMessageTemplate $botMessageTemplate): RedirectResponse 
    {        
        $users = User::select('telegram_id')
            ->distinct('telegram_id')
            ->withoutGlobalScopes()      
            ->whereNotNull('users.telegram_id')
            ->get();
            
        $text = GenerateTextFromTemplateAction::run($botMessageTemplate);        

        foreach ($users as $user) {
            $message = new BotMessageData(
                chat_id: $user->telegram_id,
                text: $text,
                parse_mode: 'markdown',
                disable_web_page_preview: false,
              );
              
            BotNotificationJob::dispatchSync($message);
        }

        UpdateTemplateCountersAction::run($botMessageTemplate);
        
        return redirect()->route('admin.bot_message_templates.edit', $botMessageTemplate)->with('success', $botMessageTemplate->id);
    }
}
