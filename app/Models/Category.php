<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'color',
        'is_default',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ideas()
    {
        return $this->belongsToMany(Idea::class, 'categories_ideas', 'category_id', 'idea_id');
    }
}
