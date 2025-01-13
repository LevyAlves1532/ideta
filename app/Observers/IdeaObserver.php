<?php

namespace App\Observers;

use App\Models\Idea;
use App\Traits\TimeUseSystemTrait;
use App\Traits\LogTrait;

class IdeaObserver
{
    /**
     * Handle the Idea "created" event.
     */
    public function created(Idea $idea): void
    {
        $user = $idea->user;

        $metric = $user->metric;

        $metric->total_ideas += 1;
        $metric->total_usage_time += TimeUseSystemTrait::saveTime();
        $metric->save();

        LogTrait::create($user->id, Idea::class, $idea->id, 'Criando ideia: ' . $idea->title, json_encode($idea));
    }

    /**
     * Handle the Idea "updated" event.
     */
    public function updated(Idea $idea): void
    {
        $user = $idea->user;

        $metric = $user->metric;

        $metric->total_usage_time += TimeUseSystemTrait::saveTime();
        $metric->save();

        LogTrait::create($user->id, Idea::class, $idea->id, 'Editando ideia: ' . $idea->title, json_encode($idea));
    }

    /**
     * Handle the Idea "deleted" event.
     */
    public function deleted(Idea $idea): void
    {
        $user = $idea->user;

        $metric = $user->metric;

        $metric->total_ideas -= 1;
        $metric->total_usage_time += TimeUseSystemTrait::saveTime();
        $metric->save();

        LogTrait::create($user->id, Idea::class, $idea->id, 'Deletando ideia: ' . $idea->title, json_encode($idea));
    }

    /**
     * Handle the Idea "restored" event.
     */
    public function restored(Idea $idea): void
    {
        //
    }

    /**
     * Handle the Idea "force deleted" event.
     */
    public function forceDeleted(Idea $idea): void
    {
        //
    }
}
