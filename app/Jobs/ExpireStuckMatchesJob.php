<?php

namespace App\Jobs;

use App\Models\MatchModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ExpireStuckMatchesJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $matches = MatchModel::where('status', 'awaiting_deposit')
            ->where('created_at', '<=', now()->subDays(3))
            ->get();

        foreach ($matches as $match) {

            // 1. помечаем сделку как просроченную
            $match->update(['status' => 'expired']);

            // 2. возвращаем объявления на рынок
            if ($match->buyListing) {
                $match->buyListing->update(['status' => 'active']);
            }

            if ($match->sellListing) {
                $match->sellListing->update(['status' => 'active']);
            }

            // 3. (опционально) лог
            Log::info('EXPIRED MATCH', [
                'match' => $match->id,
            ]);
        }
    }
}
