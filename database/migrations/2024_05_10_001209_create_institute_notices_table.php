<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstituteNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institute_notices', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('notice');
            $table->foreignId('given_by')->nullable()->constrained('users')->onDelete('SET NULL');
            $table->foreignId('institute')->constrained('institutes')->onDelete('CASCADE');
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
        Schema::dropIfExists('institute_notices');
    }
}
