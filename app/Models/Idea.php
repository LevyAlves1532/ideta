<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    protected $fillable = [
        'user_id',
        'title',
    ];

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
