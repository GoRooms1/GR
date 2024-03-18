<?php

declare(strict_types=1);

namespace Support\Actions;

use Domain\User\ValueObjects\ClientsPhoneNumberValueObject;
use Exception;
use Illuminate\Support\Facades\Http;
use Lorisleiva\Actions\Action;

final class SendWappiMessageAction extends Action
{    
    public function handle(string $phone, string $message)
    {
        $phone = (new ClientsPhoneNumberValueObject($phone))->toCleanNative();
        $url = 'https://wappi.pro/api/sync/message/send?profile_id=' . config('services.whatsapp.wappi.profile');

        $response = Http::acceptJson()
        ->withHeaders([
            'Authorization' => config('services.whatsapp.wappi.token')
        ])
        ->post($url, [
            'body' => $message,
            'recipient' => $phone
        ]);

        if (!$response->successful()) {
            throw new Exception('An error occurred when sending a message via Whatsapp');
        }

        $data = $response->json();

        if ($data['status'] !== 'done') {
            throw new Exception('An error occurred when sending a message via Whatsapp');
        }
    }   
}
