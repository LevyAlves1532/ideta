<?php

namespace App\Observers;

use App\Models\Category;
use App\Traits\TimeUseSystemTrait;
use App\Traits\LogTrait;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        $user = $category->user;

        $metric = $user->metric;

        $metric->total_categories += 1;
        $metric->last_category_created = $category->id;
        $metric->total_usage_time += TimeUseSystemTrait::saveTime();
        $metric->save();

        LogTrait::create($user->id, Category::class, $category->id, 'Criando categoria: ' . $category->name, json_encode($category));
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        $user = $category->user;

        $metric = $user->metric;

        $metric->total_usage_time += TimeUseSystemTrait::saveTime();
        $metric->save();

        LogTrait::create($user->id, Category::class, $category->id, 'Editando categoria: ' . $category->name, json_encode($category));
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        $user = $category->user;

        $metric = $user->metric;

        $metric->total_categories -= 1;
        $metric->total_usage_time += TimeUseSystemTrait::saveTime();
        $metric->save();

        LogTrait::create($user->id, Category::class, $category->id, 'Deletando categoria: ' . $category->name, json_encode($category));
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Category $category): void
    {
        //
    }
}
