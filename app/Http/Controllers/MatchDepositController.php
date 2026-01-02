<?php

namespace App\Http\Controllers;

use App\Models\MatchModel;
use Illuminate\Support\Facades\Auth;

class MatchDepositController extends Controller
{
    public function store(MatchModel $match)
    {
        $user = Auth::user();

        // Проверяем — вдруг депозит уже внесён
        $alreadyPaid = $match->deposits()
            ->where('user_id', $user->id)
            ->where('status', 'paid')
            ->exists();

        if ($alreadyPaid) {
            return redirect()
                ->route('profile.matches.show', $match)
                ->with('info', 'Вы уже внесли депозит по этой сделке.');
        }

        // Сумма депозита = 1%
        $amount = round($match->final_price * 0.01);

        // Создаём депозит
        $match->deposits()->create([
            'user_id' => $user->id,
            'amount'  => $amount,
            'status'  => 'paid',
        ]);

        // 👉 Теперь сделка — АКТИВНАЯ
        $match->update([
            'status' => 'in_progress',
        ]);

        return redirect()
            ->route('profile.matches.show', $match)
            ->with('success', 'Депозит внесён. Контакты контрагента открыты.');
    }
}
