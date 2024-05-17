<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class InstituteDepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $userCount = 102;

        $pass = [];
        for ($i = 0; $i < rand(1, 10); $i++){
            $pass[] = Str::random(10);
        }

        $admins = [];
        for ($i = 0; $i < rand(1, 10); $i++){
            $admins[] = $this->faker->numberBetween(1, $userCount);
        }

        $subjects = [];
        $random_Subjects = ["Anthropology", "Archaeology", "History", "Philosophy", "Religion", "The Arts", "Economics", "Geography", "Political Science", "Psychology", "Sociology", "Biology", "Chemistry", "Earth Science", "Physics", "Computer Science", "Mathematics", "Statistics", "Divinity", "Education", "Medicine", "Military Science", "Public Health", "Engineering", "Law", "Business Administration", "Environmental Science", "Linguistics", "Literature", "Music", "Theater", "Film Studies", "Communication", "Social Work", "Nursing", "Architecture", "Urban Planning", "Astronomy", "Nutrition", "Fine Arts", "Design", "Anthropology", "Criminology", "Gender Studies", "Ethics", "International Relations", "Philology", "Sports Science", "Cognitive Science", "Environmental Studies", "Geology", "Oceanography", "Materials Science", "Biochemistry", "Biomedical Engineering", "Political Economy", "Religious Studies", "Health Sciences", "Information Technology", "Robotics", "Data Science", "Neuroscience", "Paleontology", "Meteorology", "Actuarial Science", "Forensic Science", "Industrial Design", "Fashion Design", "Tourism Management", "Hospitality Management", "Library Science", "Archival Studies", "Cultural Studies", "Development Studies", "Peace and Conflict Studies", "Ethnomusicology", "Food Science", "Gerontology", "Human Rights", "Marine Biology", "Molecular Biology", "Parapsychology", "Quantum Physics", "Renewable Energy", "Space Science", "Zoology"];
        for ($i = 0; $i < rand(1, 20); $i++){
            $subject_name = $random_Subjects[random_int(0, 75)];
            $subject_reward = random_int(1,3)." ".["Credits", "Marks", "Points"][random_int(0, 2)];
            $subjects[$subject_name] = $subject_reward;
        }

        return [
            'institute' => random_int(227, 726),
            'name' => $this->faker->company(),
            'description' => $this->faker->realText(2000),
            'department_head' => $this->faker->numberBetween(1, 102),
            'passkeys' => $pass,
            'admins' => $admins,
            // subjects= ['name'= name, 'reward'= rewards(parcentage/marks/credit)]
            'subjects' => $subjects,
        ];
    }
}
