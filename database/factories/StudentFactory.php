<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->faker->locale = 'en_IN';
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->freeEmail(),
            'username' => $this->faker->username(),
            'phone' => $this->faker->phoneNumber(),
            'dob' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'status' => $this->faker->randomElement(['0', '1']),
        ];
    }
}
