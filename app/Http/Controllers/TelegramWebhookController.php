<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class TelegramWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $message = $request->input('message');
        if (! $message) {
            return response()->json(['ok' => true]);
        }

        $telegramId = $message['from']['id'];
        $text = $message['text'] ?? '';

        // /start 123
        if (str_starts_with($text, '/start')) {
            $userId = (int) trim(str_replace('/start', '', $text));

            if ($userId > 0) {
                User::where('id', $userId)
                    ->update(['telegram_id' => $telegramId]);
            }
        }

        return response()->json(['ok' => true]);
    }
}
