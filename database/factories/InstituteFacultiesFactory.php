<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Institute;
use App\Models\InstituteFaculties;

class InstituteFacultiesFactory extends Factory
{

    protected $model = InstituteFaculties::class;


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
            $facultyId = random_int(1, $userCount);
            $instituteId = random_int(1, $userCount);
            $combination = InstituteFaculties::where('faculty', $facultyId)
                                      ->where('institute', $instituteId)
                                      ->exists();
        } while ($combination);

        return [
            'faculty' => $facultyId,
            'institute' => $instituteId,
            'passkey_upon_joining' => Str::random(10),
        ];
    }
}
