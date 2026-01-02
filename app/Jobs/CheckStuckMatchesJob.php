<?php

namespace App\Jobs;

use App\Models\MatchModel;
use Illuminate\Support\Facades\Log;

class CheckStuckMatchesJob
{
    public function handle()
    {
        $count = MatchModel::where('status', 'awaiting_deposit')
            ->where('created_at', '<=', now()->subDays(3))
            ->count();

        Log::info('stuck matches count', [
            'count' => $count
        ]);
    }
}
