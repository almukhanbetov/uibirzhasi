<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingDraft extends Model
{
    protected $fillable = [
        'user_id',
        'type_id',
        'deal_type',
        'region_id',
        'city_id',
        'district_id',
        'area',
        'rooms',
        'price_base',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photos()
    {
        return $this->hasMany(ListingDraftPhoto::class);
    }
}
