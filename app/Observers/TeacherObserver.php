<?php

namespace App\Observers;

use App\Models\Teacher;
use App\Notifications\TeacherUpdatedNotification;
use Illuminate\Support\Facades\Notification;

// looks the same like policy

class TeacherObserver
{
    /**
     * Handle the Teacher "created" event.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return void
     */
    public function created(Teacher $teacher)
    {
        //
    }

    /**
     * Handle the Teacher "updated" event.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return void
     */
    public function updated(Teacher $teacher)
    {
        Notification::route('mail', 'admin@classroombooking.com')
            ->notify(new TeacherUpdatedNotification($teacher));
    }

    /**
     * Handle the Teacher "deleted" event.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return void
     */
    public function deleted(Teacher $teacher)
    {
        //
    }

    /**
     * Handle the Teacher "restored" event.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return void
     */
    public function restored(Teacher $teacher)
    {
        //
    }

    /**
     * Handle the Teacher "force deleted" event.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return void
     */
    public function forceDeleted(Teacher $teacher)
    {
        //
    }
}