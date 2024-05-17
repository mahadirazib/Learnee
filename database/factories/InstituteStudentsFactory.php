<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


use App\Models\User;
use App\Models\Institute;
use App\Models\InstituteStudents;

class InstituteStudentsFactory extends Factory
{

    protected $model = InstituteStudents::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $userCount = 20;

        $combination = null;
        do {
            $studntId = random_int(1, $userCount);
            $InstituteId = random_int(1, $userCount);
            $combination = InstituteStudents::where('student', $studntId)
                                      ->where('institute', $InstituteId)
                                      ->exists();
        } while ($combination);

        return [
            'student' => $studntId,
            'institute' => $InstituteId,
            'passkey_upon_joining' => Str::random(10),
        ];
    }
}
