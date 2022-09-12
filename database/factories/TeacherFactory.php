<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // $fakerMY = \Faker\Factory::create('ms_MY'); // another way if dont want to change in app.php config's folder ('faker_locale' => 'ms_MY',)

        return [
            'name' => $this->faker->name(),
            'password' => $this->faker->password(),
        ];
    }

    /**
     * Changing the name to uppercase
     *
     * @return string
     */
    public function upTheName()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => strtoupper($attributes['name']),
            ];
        });
    }
}
