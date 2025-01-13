<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMetric extends Model
{
    protected $fillable = [
        'user_id',
        'total_categories',
        'total_ideas',
        'total_notes',
        'total_usage_time',
        'last_category_created',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'last_category_created');
    }
}
