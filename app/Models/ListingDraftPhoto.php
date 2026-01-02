<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingDraftPhoto extends Model
{
    protected $fillable = [
        'listing_draft_id',
        'url',
    ];

    public function draft()
    {
        return $this->belongsTo(ListingDraft::class, 'listing_draft_id');
    }
}
