<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MatchModel;
use App\Services\MatchService;
use Illuminate\Support\Facades\Request;

class AdminMatchController extends Controller
{
    public function index()
    {
        $matches = MatchModel::with(['buyer', 'seller'])
            ->orderByDesc('id')
            ->paginate(20);

        return view('admin.matches.index', compact('matches'));
    }

    public function show(MatchModel $match)
    {
        $match->load(['buyer', 'seller', 'logs', 'deposits']);

        return view('admin.matches.show', compact('match'));
    }

    public function update(MatchModel $match, Request $request)
    {
        $data = $request->validate([
            'status' => 'required|string',
        ]);
        MatchService::setStatus($match, $data['status']);

        return back()->with('success', 'Статус обновлён администратором');
    }
}
