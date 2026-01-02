<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\MatchMonitorService;
use Illuminate\Http\Request;
use App\Models\MatchModel;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {

      
        $counters = [
            'users'     => User::count(),
            // 'listings'  => MatchModel::count(),
            // 'matches'   => MatchModel::count(),
            // 'awaiting'  => MatchModel::where('status', 'awaiting_deposit')->count(),
            // 'active'    => MatchModel::where('status', 'in_progress')->count(),
            // 'done'      => MatchModel::where('status', 'done')->count(),
            // 'canceled'  => MatchModel::where('status', 'canceled')->count(),
        ];
        
        return view('admin.dashboard', compact('counters'));
    }
}
