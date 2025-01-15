<?php

namespace App\Models;

use App\Observers\IdeaObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([IdeaObserver::class])]
class Idea extends Model
{
    protected $fillable = [
        'user_id',
        'title',
    ];

    public function ideasShares()
    {
        return $this->hasMany(IdeaShare::class);
    }

    public function logs()
    {
        return $this->morphMany(Log::class, 'modelable');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'categories_ideas', 'idea_id', 'category_id');
    }

    public function notes()
    {
        return $this->hasMany(Note::class, 'idea_id');
    }
}
