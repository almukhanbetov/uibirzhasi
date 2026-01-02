<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\City;
use App\Models\District;
use App\Models\MatchModel;
use App\Models\Photo;
use App\Models\PriceHistory;
use App\Models\Region;
use App\Models\Type;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Listing extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'deal_type',       // buy | sale
        'type_id',         // квартира, дом и т.д.
        'region_id',
        'city_id',
        'district_id',
        'area',
        'rooms',
        'price_base',
        'price_current',
        // 🔑 биржевая логика
        'price_step_pct',
        'price_step_days',
        'last_price_change_at',
        'status',          // active | matched | expired | closed
        'description',
    ];
    protected $casts = [
        'last_price_change_at' => 'datetime',
    ];
    /* =========================
     | Константы
     ========================= */
    const DEAL_SALE = 'sale';
    const DEAL_BUY  = 'buy';
    const STATUS_ACTIVE  = 'active';
    const STATUS_MATCHED = 'matched';
    const STATUS_EXPIRED = 'expired';
    const STATUS_CLOSED  = 'closed';
    /* =========================
     | UI helpers
     ========================= */
    public static function dealTypes(): array
    {
        return [
            self::DEAL_SALE => 'Продажа',
            self::DEAL_BUY  => 'Покупка',
        ];
    }
    public function getDealNameAttribute(): string
    {
        return self::dealTypes()[$this->deal_type] ?? $this->deal_type;
    }
    /* =========================
     | Relations
     ========================= */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
    public function getMainPhotoAttribute(): string
    {
        $photo = $this->photos->first();

        if ($photo && $photo->url) {
            return Storage::url($photo->url);
        }

        return asset('images/no-image.png');
    }

    public function priceHistories()
    {
        return $this->hasMany(PriceHistory::class);
    }
    public function statusHistory()
    {
        return $this->hasMany(StatusHistory::class);
    }

    public function matches()
    {
        return $this->hasMany(MatchModel::class, 'buyer_id')
            ->orWhere('seller_id', $this->id);
    }

    /* =========================
     | Scopes
     ========================= */
    public function scopeActive($q)
    {
        return $q->where('status', self::STATUS_ACTIVE);
    }

    public function scopeBuy($q)
    {
        return $q->where('deal_type', self::DEAL_BUY);
    }

    public function scopeSale($q)
    {
        return $q->where('deal_type', self::DEAL_SALE);
    }
}
