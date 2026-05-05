<?php
namespace App\Http\Controllers;
use App\Models\MatchModel;
use Illuminate\Support\Facades\Auth;
class MatchDepositController extends Controller
{
    public function store(MatchModel $match)
    {
        $user = Auth::user();

        if ($match->buyer_id !== $user->id && $match->seller_id !== $user->id) {
            abort(403);
        }

        if ($match->status !== 'awaiting_deposit') {
            return redirect()
                ->route('profile.matches.show', $match)
                ->with('info', 'Сделка уже активна или завершена.');
        }

        $alreadyPaid = $match->deposits()
            ->where('user_id', $user->id)
            ->where('status', 'paid')
            ->exists();

        if ($alreadyPaid) {
            return redirect()
                ->route('profile.matches.show', $match)
                ->with('info', 'Вы уже внесли депозит.');
        }

        $amount = round($match->final_price * 0.01);

        $match->deposits()->create([
            'user_id' => $user->id,
            'amount'  => $amount,
            'status'  => 'paid',
        ]);

        if ($match->buyer_id == $user->id) {
            $match->buyer_deposit_paid = true;
        }

        if ($match->seller_id == $user->id) {
            $match->seller_deposit_paid = true;
        }

        if ($match->buyer_deposit_paid && $match->seller_deposit_paid) {
            $match->status = 'in_progress';
        }

        $match->save();

        $message = 'Депозит внесён.';

        if ($match->status === 'in_progress') {
            $message .= ' Контакты открыты.';
        } else {
            $message .= ' Ожидаем второго участника.';
        }

        return redirect()
            ->route('profile.matches.show', $match)
            ->with('success', $message);
    }
}
