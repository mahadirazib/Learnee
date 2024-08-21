<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFacultyToClassroomFacultiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('classroom_faculties', function (Blueprint $table) {
            $table->foreignId('faculty')->constrained('users')->onDelete('CASCADE');
            $table->foreignId('institute')->constrained('institutes')->onDelete('CASCADE');
            $table->foreignId('department')->constrained('institute_departments')->onDelete('CASCADE');
            $table->foreignId('classroom')->constrained('department_classrooms')->onDelete('CASCADE');
            $table->string('passkey_upon_joining')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('classroom_faculties', function (Blueprint $table) {
            //
        });
    }
}
