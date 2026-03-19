<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageBlock extends Model
{
    protected $fillable = [
        'page_id',
        'type',
        'data',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'data' => 'array'
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
