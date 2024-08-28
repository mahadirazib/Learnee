<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassroomNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classroom_notices', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('notice');
            $table->foreignId('given_by')->nullable()->constrained('users')->onDelete('SET NULL');
            $table->foreignId('classroom')->constrained('department_classrooms')->onDelete('CASCADE');
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
        Schema::dropIfExists('classroom_notices');
    }
}
