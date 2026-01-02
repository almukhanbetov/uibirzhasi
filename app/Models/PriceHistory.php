<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class PriceHistory extends Model
{
    protected $fillable = [
        'listing_id',
        'old_price',
        'new_price',
        'reason',
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}