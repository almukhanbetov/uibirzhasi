<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function show()
    {
        return view('offer.accept', [
            'version' => config('offer.current_version'),
        ]);
    }

    public function accept(Request $request)
    {
        $request->validate([
            'accepted_offer' => 'accepted',
        ]);

        $user = $request->user();

        $user->update([
            'accepted_offer' => true,
            'accepted_offer_at' => now(),
            'accepted_offer_ip' => $request->ip(),
            'accepted_offer_version' => config('offer.current_version'),
        ]);

        return redirect('/dashboard');
    }
}
