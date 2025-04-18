<?php

namespace App\Observers;

use App\Models\Category;
use App\Models\Idea;
use App\Models\Note;
use App\Models\User;
use App\Models\UserMetric;
use App\Traits\TimeUseSystemTrait;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $user_id = $user->id;
        
        $user_metric = UserMetric::create([
            'user_id' => $user_id,
            'total_categories' => Category::where('user_id', $user_id)->count(),
            'total_ideas' => Idea::where('user_id', $user_id)->count(),
            'total_notes' => Note::where('user_id', $user_id)->count(),
        ]);

        $category = Category::create([
            'user_id' => $user->id,
            'name' => 'Todas',
            'slug' => 'todas',
            'color' => '#000000',
            'is_default' => true,
        ]);

        $user_metric->last_category_created = $category->id;
        $user_metric->save();
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        $metric = $user->metric;

        $metric->total_usage_time += TimeUseSystemTrait::saveTime();
        $metric->save();
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
