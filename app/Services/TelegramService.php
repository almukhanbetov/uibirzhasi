<?php


namespace App\Services;

use Illuminate\Support\Facades\Http;

class TelegramService
{
    public function send(int $chatId, string $text): void
    {
        Http::post(
            'https://api.telegram.org/bot' . config('services.telegram.token') . '/sendMessage',
            [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'HTML',
            ]
        );
    }
}
