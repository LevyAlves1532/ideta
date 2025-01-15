<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdeaShare extends Model
{
    protected $fillable = [
        'user_id',
        'idea_id',
        'token',
        'expires_in',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function idea()
    {
        return $this->belongsTo(Idea::class);
    }
}
