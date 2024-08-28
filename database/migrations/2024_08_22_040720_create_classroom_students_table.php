<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassroomStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classroom_students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student')->constrained('users')->onDelete('CASCADE');
            $table->foreignId('institute')->constrained('institutes')->onDelete('CASCADE');
            $table->foreignId('department')->constrained('institute_departments')->onDelete('CASCADE');
            $table->foreignId('classroom')->constrained('department_classrooms')->onDelete('CASCADE');
            $table->string('passkey_upon_joining')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classroom_students');
    }
}
