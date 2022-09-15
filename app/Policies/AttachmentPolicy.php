<?php

namespace App\Policies;

use App\Models\Attachment;
use App\Models\Teacher;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttachmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(Teacher $teacher)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Teacher  $teacher
     * @param  \App\Models\Attachment  $attachment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Teacher $teacher, Attachment $attachment)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Teacher $teacher)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Teacher  $teacher
     * @param  \App\Models\Attachment  $attachment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Teacher $teacher, Attachment $attachment)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Teacher  $teacher
     * @param  \App\Models\Attachment  $attachment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Teacher $teacher, Attachment $attachment)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Teacher  $teacher
     * @param  \App\Models\Attachment  $attachment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Teacher $teacher, Attachment $attachment)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Teacher  $teacher
     * @param  \App\Models\Attachment  $attachment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Teacher $teacher, Attachment $attachment)
    {
        //
    }
}
