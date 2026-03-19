<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['slug', 'is_active'];

    public function blocks()
    {
        return $this->hasMany(PageBlock::class)
            ->where('is_active', true)
            ->orderBy('sort_order');
    }

    public function seo()
    {
        return $this->morphOne(SeoMeta::class, 'model');
    }
}
