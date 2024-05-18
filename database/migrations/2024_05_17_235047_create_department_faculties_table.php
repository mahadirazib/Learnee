<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentFacultiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department_faculties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faculty')->constrained('users')->onDelete('CASCADE');
            $table->foreignId('department')->constrained('institute_departments')->onDelete('CASCADE');
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
        Schema::dropIfExists('department_faculties');
    }
}
