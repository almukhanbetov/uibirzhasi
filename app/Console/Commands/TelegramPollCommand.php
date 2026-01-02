<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class TelegramPollCommand extends Command
{
    protected $signature = 'telegram:poll';
    protected $description = 'Poll Telegram updates (local dev)';

    public function handle()
    {
        $offset = cache()->get('telegram_offset', 0);

        $res = Http::get(
            'https://api.telegram.org/bot' . config('services.telegram.token') . '/getUpdates',
            [
                'timeout' => 10,
                'offset' => $offset,
            ]
        )->json();

        foreach ($res['result'] ?? [] as $update) {
            cache()->put('telegram_offset', $update['update_id'] + 1);

            $message = $update['message'] ?? null;
            if (! $message) continue;

            $telegramId = $message['from']['id'];
            $text = $message['text'] ?? '';

            // /start 123
            if (str_starts_with($text, '/start')) {
                $userId = (int) trim(str_replace('/start', '', $text));

                if ($userId) {
                    User::where('id', $userId)
                        ->update(['telegram_id' => $telegramId]);

                    $this->info("User {$userId} linked to Telegram {$telegramId}");
                }
            }
        }
    }
}
