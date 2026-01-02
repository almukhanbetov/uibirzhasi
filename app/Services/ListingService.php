<?php
namespace App\Services;
use App\Models\City;
use App\Models\District;
use App\Models\Listing;
use App\Models\PriceHistory;
use App\Models\Region;
use App\Models\Type;
use Illuminate\Support\Facades\DB;
class ListingService
{
    /**
     * Создание объявления
     */
    public function create(array $data): Listing
    {
        return DB::transaction(function () use ($data) {
            $listing = Listing::create([
                ...$data,
                'price_current' => $data['price_base'],
                'status'        => Listing::STATUS_ACTIVE,
            ]);
            // фиксируем стартовую цену
            PriceHistory::create([
                'listing_id' => $listing->id,
                'old_price'  => $listing->price_base,
                'new_price'  => $listing->price_base,
                'reason'     => 'created',
            ]);

            return $listing;
        });
    }
    /**
     * Обновление пользователем
     */
    public function update(Listing $listing, array $data): Listing
    {
        return DB::transaction(function () use ($listing, $data) {

            $oldPrice = $listing->price_current;
            $listing->update($data);
            // если пользователь изменил цену вручную
            if (
                array_key_exists('price_current', $data) &&
                (int)$oldPrice !== (int)$listing->price_current
            ) {
                PriceHistory::create([
                    'listing_id' => $listing->id,
                    'old_price'  => $oldPrice,
                    'new_price'  => $listing->price_current,
                    'reason'     => 'manual',
                ]);
            }
            return $listing;
        });
    }
    /**
     * Автоматический шаг цены (scheduler)
     */
    public function autoStep(Listing $listing): void
    {
        if ($listing->status !== Listing::STATUS_ACTIVE) {
            return;
        }
        $old = $listing->price_current;
        $delta = round($old * ($listing->price_step_pct / 100));
        if ($delta <= 0) return;
        $listing->price_current +=
            $listing->deal_type === Listing::DEAL_BUY
                ? $delta
                : -$delta;
        $listing->last_price_change_at = now();
        $listing->save();
        PriceHistory::create([
            'listing_id' => $listing->id,
            'old_price'  => $old,
            'new_price'  => $listing->price_current,
            'reason'     => 'auto_step',
        ]);
    }
     public function dictionaries(): array
    {
        return [
            'regions' => Region::orderBy('name')->get(),
            'cities' => City::orderBy('name')->get(),
            'districts' => District::orderBy('name')->get(),
            'types' => Type::orderBy('name')->get(),

            'deal_types' => [
                Listing::DEAL_SALE => 'Продажа',
                Listing::DEAL_BUY  => 'Покупка',
            ],
        ];
    }
}
