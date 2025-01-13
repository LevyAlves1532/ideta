<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'modelable_type',
        'modelable_id',
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function modelable()
    {
        return $this->morphTo('modelable');
    }
}
