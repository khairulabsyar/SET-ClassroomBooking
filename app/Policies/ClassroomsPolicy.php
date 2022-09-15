<?php

namespace App\Policies;

use App\Models\Teacher;
use App\Models\classrooms;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClassroomsPolicy
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
     * @param  \App\Models\classrooms  $classrooms
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Teacher $teacher, classrooms $classrooms)
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
     * @param  \App\Models\classrooms  $classrooms
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Teacher $teacher, classrooms $classrooms)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Teacher  $teacher
     * @param  \App\Models\classrooms  $classrooms
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Teacher $teacher, classrooms $classrooms)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Teacher  $teacher
     * @param  \App\Models\classrooms  $classrooms
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Teacher $teacher, classrooms $classrooms)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Teacher  $teacher
     * @param  \App\Models\classrooms  $classrooms
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Teacher $teacher, classrooms $classrooms)
    {
        //
    }
}
