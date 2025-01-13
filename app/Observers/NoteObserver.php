<?php

namespace App\Observers;

use App\Models\Note;
use App\Traits\TimeUseSystemTrait;
use App\Traits\LogTrait;

class NoteObserver
{
    /**
     * Handle the Note "created" event.
     */
    public function created(Note $note): void
    {
        $user = $note->user;

        $metric = $user->metric;

        $metric->total_notes += 1;
        $metric->total_usage_time += TimeUseSystemTrait::saveTime();
        $metric->save();

        LogTrait::create($user->id, Note::class, $note->id, 'Criando anotação: ' . base64_encode($note->id), json_encode($note));
    }

    /**
     * Handle the Note "updated" event.
     */
    public function updated(Note $note): void
    {
        $user = $note->user;

        $metric = $user->metric;

        $metric->total_usage_time += TimeUseSystemTrait::saveTime();
        $metric->save();

        LogTrait::create($user->id, Note::class, $note->id, 'Editando anotação: ' . base64_encode($note->id), json_encode($note));
    }

    /**
     * Handle the Note "deleted" event.
     */
    public function deleted(Note $note): void
    {
        $user = $note->user;

        $metric = $user->metric;

        $metric->total_notes -= 1;
        $metric->total_usage_time += TimeUseSystemTrait::saveTime();
        $metric->save();

        LogTrait::create($user->id, Note::class, $note->id, 'Deletando anotação: ' . base64_encode($note->id), json_encode($note));
    }

    /**
     * Handle the Note "restored" event.
     */
    public function restored(Note $note): void
    {
        //
    }

    /**
     * Handle the Note "force deleted" event.
     */
    public function forceDeleted(Note $note): void
    {
        //
    }
}
