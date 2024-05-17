<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class InstituteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $userCount = 20;

        $emails = [];
        for ($i = 0; $i < rand(1, 3); $i++){
            $emails[] = $this->faker->email;
        }

        $admins = [];
        for ($i = 0; $i < rand(1, 3); $i++){
            $admins[] = $this->faker->numberBetween(1, $userCount);
        }

        $pass = [];
        for ($i = 0; $i < rand(1, 3); $i++){
            $pass[] = Str::random(10);
        }

        $mobile = [];
        for ($i = 0; $i < rand(1, 3); $i++){
            $mobile[] = random_int(548795126, 999999999);
        }

        $images = [];
        for ($i = 0; $i < rand(1, 10); $i++){
            $images[] = "../default_images/institute_gellary/image (".random_int(1,28).").jpg";
        }


        return [
            'name'=> ['Institute of ', 'University of ', ""][random_int(0, 2)].$this->faker->streetName(),
            'description' => $this->faker->realText(500),
            'created_by' => $this->faker->numberBetween(1, $userCount),
            'institute_head' => $this->faker->numberBetween(1, $userCount),
            'admins' => $admins,
            'passkeys' => $pass,
            'emails' => $emails,
            'mobile_numbers' => $mobile,
            'images' => $images,
            'address_one' => $this->faker->address(),
            'address_two' => $this->faker->address()
        ];
    }
}
