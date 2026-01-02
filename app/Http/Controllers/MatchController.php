<?php

namespace App\Http\Controllers;

use App\Models\MatchModel;
use Illuminate\Support\Facades\Auth;

class MatchController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
        // Ожидают депозита
        $awaiting = MatchModel::with(['buyerListing', 'sellerListing'])
            ->where('status', 'awaiting_deposit')
            ->where(function ($q) use ($userId) {
                $q->where('buyer_id', $userId)
                    ->orWhere('seller_id', $userId);
            })
            ->orderByDesc('id')
            ->get();
        // Активные сделки       
        $active = MatchModel::with(['buyerListing', 'sellerListing'])
            ->where('status', 'in_progress')
            ->where(function ($q) use ($userId) {
                $q->where('buyer_id', $userId)
                    ->orWhere('seller_id', $userId);
            })
            ->orderByDesc('id')
            ->get();
        // Завершённые       
        $done = MatchModel::with(['buyerListing', 'sellerListing'])
            ->where('status', 'completed')
            ->where(function ($q) use ($userId) {
                $q->where('buyer_id', $userId)
                    ->orWhere('seller_id', $userId);
            })
            ->orderByDesc('id')
            ->get();
        // Отменённые / Истёкшие
        $canceled = MatchModel::with(['buyerListing', 'sellerListing'])
            ->whereIn('status', ['canceled', 'expired'])
            ->where(function ($q) use ($userId) {
                $q->where('buyer_id', $userId)
                    ->orWhere('seller_id', $userId);
            })
            ->orderByDesc('id')
            ->get();
        return view('matches.index', compact(
            'awaiting',
            'active',
            'done',
            'canceled'
        ));
    }
    public function show($id)
    {
        $match = MatchModel::with([
            'buyer',
            'seller',
            'buyerListing.user',
            'sellerListing.user',
            'deposits'
        ])->findOrFail($id);
           
        abort_unless(
            $match->buyer_id === Auth::user()->id ||
                $match->seller_id === Auth::user()->id,
            403
        );

        return view('matches.show', compact('match'));
    }
    // public function show($id){
    //     $match = MatchModel::find($id);
      
    //     return view("matches.show", compact('match'));

    // }
}
