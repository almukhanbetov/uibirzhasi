<?php

namespace App\Services;

use App\Models\Listing;
use App\Models\MatchModel;
use App\Models\StatusHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MatchMonitorService
{
    public function checkListingForMatch(Listing $changed): void
    {
        // Проверяем только активные объявления
        if ($changed->status !== Listing::STATUS_ACTIVE) {
            return;
        }
        $tolerance = config('match.price_tolerance_pct', 2);
        // Определяем противоположный тип
        $opposite = $changed->deal_type === Listing::DEAL_SALE
            ? Listing::DEAL_BUY
            : Listing::DEAL_SALE;
        // Ищем объявления с такими же характеристиками
        $candidates = Listing::query()
            ->where('deal_type', $opposite)
            ->where('status', Listing::STATUS_ACTIVE)
            ->where('id', '!=', $changed->id)
            // 🔽 ТУТ СОПСТАВЛЯЕМ ХАРАКТЕРИСТИКИ
            ->where('city_id', $changed->city_id)
            ->where('district_id', $changed->district_id)
            ->where('type_id', $changed->type_id)
            ->get();
        foreach ($candidates as $other) {
            // Определяем кто BUY / SELL
            if ($changed->deal_type === Listing::DEAL_BUY) {
                $buy  = $changed;
                $sale = $other;
            } else {
                $buy  = $other;
                $sale = $changed;
            }
            // Считаем разницу в %
            $diffPct = abs($buy->price_current - $sale->price_current)
                / max($buy->price_current, $sale->price_current)
                * 100;
            if ($diffPct <= $tolerance) {

                $this->createCandidateMatch($buy, $sale);
            }
        }
    }
    protected function createCandidateMatch(Listing $buy, Listing $sale): void
    {
        DB::transaction(function () use ($buy, $sale) {

            $match = MatchModel::firstOrCreate(
                [
                    'buy_listing_id'  => $buy->id,
                    'sell_listing_id' => $sale->id,
                ],
                [
                    'buyer_id'   => $buy->user_id,
                    'seller_id'  => $sale->user_id,
                    'buy_price'  => $buy->price_current,
                    'sale_price' => $sale->price_current,
                    'final_price' => round(($buy->price_current + $sale->price_current) / 2, 2),
                    'status'     => 'awaiting_deposit',
                ]
            );

            if ($match->wasRecentlyCreated) {

                // запоминаем старые статусы до обновления
                $oldBuyStatus  = $buy->status;
                $oldSaleStatus = $sale->status;

                // меняем статус объявлений
                $buy->update(['status' => Listing::STATUS_MATCHED]);
                $sale->update(['status' => Listing::STATUS_MATCHED]);

                // пишем в журнал статусов
                StatusHistory::create([
                    'listing_id' => $buy->id,
                    'old_status' => $oldBuyStatus,
                    'new_status' => Listing::STATUS_MATCHED,
                    'reason'     => 'auto_match',
                ]);

                StatusHistory::create([
                    'listing_id' => $sale->id,
                    'old_status' => $oldSaleStatus,
                    'new_status' => Listing::STATUS_MATCHED,
                    'reason'     => 'auto_match',
                ]);

                Log::info('MATCH CREATED AND FROZEN', [
                    'match' => $match->id,
                    'buy'   => $buy->id,
                    'sell'  => $sale->id,
                    'final' => $match->final_price,
                ]);
            }
        });
    }
}
