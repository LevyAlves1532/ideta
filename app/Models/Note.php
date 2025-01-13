<?php

namespace App\Models;

use App\Observers\NoteObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([NoteObserver::class])]
class Note extends Model
{
    protected $fillable = [
        'user_id',
        'idea_id',
        'body',
        'position',
    ];

    public function logs()
    {
        return $this->morphMany(Log::class, 'modelable');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function idea()
    {
        return $this->belongsTo(Idea::class, 'idea_id');
    }
}
