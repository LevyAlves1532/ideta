<?php

namespace App\Models;

use App\Observers\CategoryObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([CategoryObserver::class])]
class Category extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'color',
        'is_default',
    ];

    public function userMetric()
    {
        return $this->hasOne(UserMetric::class, 'last_category_created');
    }

    public function logs()
    {
        return $this->morphMany(Log::class, 'modelable');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ideas()
    {
        return $this->belongsToMany(Idea::class, 'categories_ideas', 'category_id', 'idea_id');
    }
}
