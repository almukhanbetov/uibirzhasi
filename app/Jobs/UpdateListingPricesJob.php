<?php

namespace App\Jobs;

use App\Models\Listing;
use App\Models\PriceHistory;
use App\Services\MatchMonitorService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class UpdateListingPricesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        Log::info('PRICE JOB STARTED');

        try {

            // Берём только активные объявления
            $listings = Listing::where('status', Listing::STATUS_ACTIVE)
                ->where(function ($q) {
                    $q->whereNull('last_price_change_at')
                        ->orWhere('last_price_change_at', '<', now()->subMinutes(5));
                })
                ->get();

            foreach ($listings as $listing) {

                $old = $listing->price_current;
                $pct = $listing->price_step_pct ?? 1; // по умолчанию 1%

                // 🟥 ПРОДАЖА — цена СНИЖАЕТСЯ на 1%
                if ($listing->deal_type == Listing::DEAL_SALE) {
                    $listing->price_current = round(
                        $listing->price_current * (1 - $pct / 100)
                    );
                }

                // 🟦 ПОКУПКА — цена ПОВЫШАЕТСЯ на 1%
                if ($listing->deal_type == Listing::DEAL_BUY) {
                    $listing->price_current = round(
                        $listing->price_current * (1 + $pct / 100)
                    );
                }

                // фиксируем время последнего изменения
                $listing->last_price_change_at = now();
                $listing->save();

                // сохраняем историю
                PriceHistory::create([
                    'listing_id' => $listing->id,
                    'old_price'  => $old,
                    'new_price'  => $listing->price_current,
                    'reason'     => 'auto_step',
                ]);

                Log::info('PRICE UPDATED', [
                    'id'  => $listing->id,
                    'old' => $old,
                    'new' => $listing->price_current,
                ]);

                // 🆕 Проверяем совпадение цен (≤2%) и отправку WhatsApp
                app(MatchMonitorService::class)
                    ->checkListingForMatch($listing);
            }

            Log::info('PRICE JOB FINISHED');

        } catch (Throwable $e) {

            Log::error('PRICE JOB FAIL', [
                'msg' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
