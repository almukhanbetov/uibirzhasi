<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class MatchModel extends Model
{
    protected $table = 'matches';
    protected $fillable = [
        'buyer_id',
        'seller_id',
        'buy_listing_id',
        'sell_listing_id',
        'buy_price',
        'sale_price',
        'final_price',
        'status'
    ];
    protected $casts = [
        'buy_price'   => 'integer',
        'sale_price'  => 'integer',
        'final_price' => 'integer',
    ];
    protected $attributes = [
        'status' => 'awaiting_deposit'
    ];
    protected $appends = [
        'my_listing',
        'partner_listing',
        'expires_at'
    ];
    public function setStatus(string $new)
    {
        $old = $this->status;

        $this->update(['status' => $new]);

        MatchLog::create([
            'match_id' => $this->id,
            'user_id'  => Auth::user()->id,
            'action'   => 'status_changed',
            'details'  => "Статус: $old → $new",
        ]);
    }
    public function logs()
    {
        return $this->hasMany(\App\Models\MatchLog::class, 'match_id');
    }
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
    public function deposits()
    {
        return $this->hasMany(Deposit::class, 'match_id');
    }
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function buyerListing()
    {
        return $this->belongsTo(Listing::class, 'buy_listing_id');
    }
    public function sellerListing()
    {
        return $this->belongsTo(Listing::class, 'sell_listing_id');
    }
    public function getMyListingAttribute()
    {
        // dd('my_listing accessor', $this->buyer_id, Auth::user()->id);
        return $this->buyer_id === Auth::user()->id
            ? $this->buyerListing
            : $this->sellerListing;
    }
    public function getPartnerListingAttribute()
    {
        // dd('partner_listing accessor', $this->buyer_id,Auth::user()->id);
        return $this->buyer_id === Auth::user()->id
            ? $this->sellerListing
            : $this->buyerListing;
    }
    public function getExpiresAtAttribute()
    {
        return $this->created_at
            ? $this->created_at->addHours(24)
            : null;
    }
    // public function myListing()
    // {
    //     return $this->buyer_id === Auth::user()->id
    //         ? $this->buyerListing
    //         : $this->sellerListing;
    // }
    // public function partnerListing()
    // {
    //     return $this->buyer_id === Auth::user()->id
    //         ? $this->sellerListing
    //         : $this->buyerListing;
    // }
}
