<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(100)->create();
        // \App\Models\Institute::factory(500)->create();
        // \App\Models\InstituteNotice::factory(1000)->create();
        // \App\Models\InstituteFaculties::factory(100)->create();
        // \App\Models\InstituteStudents::factory(300)->create();
        \App\Models\InstituteDepartment::factory(500)->create();
        // \App\Models\DepartmentNotice::factory(500)->create();
        
    }
}
