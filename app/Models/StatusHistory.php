<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusHistory extends Model
{
    protected $fillable = [
        'listing_id',
        'old_status',
        'new_status',
        'reason',
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}
