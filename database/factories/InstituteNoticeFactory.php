<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class InstituteNoticeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->realText(20),
            'notice' => $this->faker->realText(300),
            'given_by' => random_int(1, 20),
            'institute'=> random_int(227, 726),
        ];
    }
}
