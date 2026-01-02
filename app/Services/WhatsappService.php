<?php

namespace App\Services;

use App\Models\MatchModel;
use Illuminate\Support\Facades\Log;

class WhatsappService
{
    public function notifyMatch(MatchModel $match): void
    {
        $buyer  = $match->buyer;   // связь buyer()
        $seller = $match->seller;  // связь seller()

        $text = sprintf(
            "Найден контрагент #%d. Цена сделки: %s ₸ (средняя между %s и %s, расхождение ≤ 2%%).",
            $match->id,
            number_format($match->final_price, 0, '.', ' '),
            number_format($match->buy_price, 0, '.', ' '),
            number_format($match->sale_price, 0, '.', ' ')
        );

        // 👉 пока просто пишем в лог вместо реального WhatsApp API
        Log::info('WHATSAPP TO BUYER', [
            'phone' => $buyer->phone ?? null,
            'text'  => $text,
        ]);

        Log::info('WHATSAPP TO SELLER', [
            'phone' => $seller->phone ?? null,
            'text'  => $text,
        ]);
    }
}
