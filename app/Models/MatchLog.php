<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchLog extends Model
{
    protected $fillable = ['match_id', 'user_id', 'action', 'details'];

    public function match()
    {
        return $this->belongsTo(\App\Models\MatchModel::class, 'match_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
