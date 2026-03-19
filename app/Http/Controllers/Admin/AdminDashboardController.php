<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Listing;
use App\Models\MatchModel;
use App\Models\Deposit;

class AdminDashboardController extends Controller
{
    public function index()
    {

        $users = User::count();
        $listings = Listing::count();
        $matches = MatchModel::count();
        $deposits = Deposit::count();

        $recentListings = Listing::latest()->limit(5)->get();

        return view('admin.dashboard',compact(
            'users',
            'listings',
            'matches',
            'deposits',
            'recentListings'
        ));

    }
}
