<?php
namespace App\Services;
use App\Models\Listing;
use App\Models\MatchLog;
use App\Models\MatchModel;
use App\Models\PriceHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class MatchService
{
    public static function setStatus(MatchModel $match, string $newStatus): void
    {
        $oldStatus = $match->status;

        // Если статус не изменился — ничего не делаем
        if ($oldStatus === $newStatus) {
            return;
        }

        // Обновляем
        $match->update([
            'status' => $newStatus
        ]);

        // Логируем
        MatchLog::create([
            'match_id' => $match->id,
            'user_id'  => Auth::user()->id,
            'action'   => 'status_changed',
            'details'  => "Статус изменён: {$oldStatus} → {$newStatus}",
        ]);
    }
    public function check(Listing $listing): ?MatchModel
    {
        if ($listing->status !== Listing::STATUS_ACTIVE) {
            return null;
        }
        $query = Listing::active()
            ->where('type_id', $listing->type_id)
            ->where('city_id', $listing->city_id)
            ->where('id', '!=', $listing->id);
        if ($listing->deal_type === Listing::DEAL_BUY) {
            $query->sale()
                ->where('price_current', '<=', $listing->price_current);
        } else {
            $query->buy()
                ->where('price_current', '>=', $listing->price_current);
        }
        $counter = $query->first();
        if (! $counter) return null;
        return DB::transaction(function () use ($listing, $counter) {
            $buyer  = $listing->deal_type === Listing::DEAL_BUY  ? $listing : $counter;
            $seller = $listing->deal_type === Listing::DEAL_SALE ? $listing : $counter;
            $price = min($buyer->price_current, $seller->price_current);
            $match = MatchModel::create([
                'buyer_id'  => $buyer->id,
                'seller_id' => $seller->id,
                'price'     => $price,
                'status'    => 'awaiting_deposit',
            ]);
            $buyer->update(['status' => Listing::STATUS_MATCHED]);
            $seller->update(['status' => Listing::STATUS_MATCHED]);         
            foreach ([$buyer, $seller] as $l) {
                PriceHistory::create([
                    'listing_id' => $l->id,
                    'old_price'  => $l->price_current,
                    'new_price'  => $price,
                    'reason'     => 'matched',
                ]);
            }
            return $match;
        });
    }
}
