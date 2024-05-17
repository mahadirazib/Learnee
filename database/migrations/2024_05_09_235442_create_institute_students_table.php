<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstituteStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institute_students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student')->constrained('users')->onDelete('CASCADE');
            $table->foreignId('institute')->constrained('institutes')->onDelete('CASCADE');
            $table->string('passkey_upon_joining')->nullable();
            $table->timestamps();

            $table->unique(['student', 'institute']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('institute_students');
    }
}
