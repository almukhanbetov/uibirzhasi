<?php
namespace App\Jobs;
use App\Models\MatchModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
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
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', now())
            ->get();

        foreach ($matches as $match) {

            DB::transaction(function () use ($match) {
                // ❌ отменяем сделку
                $match->update([
                    'status' => 'expired'
                ]);
                // 🔄 возвращаем объявления
                if ($match->buyListing) {
                    $match->buyListing->update(['status' => 'active']);
                }

                if ($match->sellListing) {
                    $match->sellListing->update(['status' => 'active']);
                }
                // 💸 ВОЗВРАТ ДЕПОЗИТОВ
                foreach ($match->deposits as $deposit) {

                    if ($deposit->status === 'paid') {

                        $deposit->update([
                            'status' => 'refunded'
                        ]);

                        Log::info('DEPOSIT REFUNDED', [
                            'match_id' => $match->id,
                            'user_id' => $deposit->user_id,
                            'amount' => $deposit->amount,
                        ]);
                    }
                }
                Log::info('MATCH EXPIRED + REFUNDED', [
                    'match_id' => $match->id
                ]);
            });
        }
    }
}
