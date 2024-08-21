<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentClassroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department_classrooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institute')->constrained('institutes')->onDelete('CASCADE');
            $table->foreignId('department')->constrained('institute_departments')->onDelete('CASCADE');
            $table->string('name');
            $table->longText('description');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('SET NULL');
            $table->foreignId('main_faculty')->nullable()->constrained('users')->onDelete('SET NULL');
            $table->json('passkeys')->nullable();
            $table->json('topics')->nullable();
            $table->json('exam_types')->nullable();
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('department_classrooms');
    }
}
