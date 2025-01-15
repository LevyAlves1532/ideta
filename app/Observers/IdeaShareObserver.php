<?php

namespace App\Observers;

use App\Models\IdeaShare;
use App\Traits\TimeUseSystemTrait;
use App\Traits\LogTrait;

class IdeaShareObserver
{
    /**
     * Handle the IdeaShare "created" event.
     */
    public function created(IdeaShare $ideaShare): void
    {
        $user = $ideaShare->user;

        $metric = $user->metric;
        $metric->total_usage_time += TimeUseSystemTrait::saveTime();
        $metric->save();

        LogTrait::create($user->id, IdeaShare::class, $ideaShare->id, 'Criando compartilhamento: ' . $ideaShare->token, json_encode($ideaShare));
    }

    /**
     * Handle the IdeaShare "updated" event.
     */
    public function updated(IdeaShare $ideaShare): void
    {
        //
    }

    /**
     * Handle the IdeaShare "deleted" event.
     */
    public function deleted(IdeaShare $ideaShare): void
    {
        //
    }

    /**
     * Handle the IdeaShare "restored" event.
     */
    public function restored(IdeaShare $ideaShare): void
    {
        //
    }

    /**
     * Handle the IdeaShare "force deleted" event.
     */
    public function forceDeleted(IdeaShare $ideaShare): void
    {
        //
    }
}
