<?php

namespace App\Http\Controllers;

use App\Models\MatchModel;
use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{
    public function create(MatchModel $match)
    {
        abort_if($match->status !== 'awaiting_deposit', 403);

        return Deposit::create([
            'match_id' => $match->id,
            'user_id'  => Auth::user()->id,
            'amount'   => config('app.deposit_amount', 100000),
            'status'   => 'pending',
        ]);
    }

    // webhook / callback от Kaspi / Halyk
    public function paid(Deposit $deposit)
    {
        $deposit->update(['status' => 'paid']);

        $deposit->match->update([
            'status' => 'contacts_opened',
        ]);
    }
}

