<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ClassroomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // 'teachers_id' => 1,
            'type_id' => 1,
            'name' => 'Classroom ' . Str::random(10),
            'date' => now()->addDays(2)->format('Y-m-d'), // return string date
            'time_start' => now()->addHour()->toTimeString(), // return string time
            'time_end' => now()->addHour(2)->toTimeString(), // return string
        ];
    }
}