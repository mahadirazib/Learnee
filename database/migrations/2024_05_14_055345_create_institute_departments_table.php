<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstituteDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institute_departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institute')->constrained('institutes')->onDelete('CASCADE');
            $table->string('name');
            $table->longText('description');
            $table->foreignId('department_head')->nullable()->constrained('users')->onDelete('SET NULL');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('SET NULL');
            $table->json('passkeys')->nullable();
            $table->json('admins')->nullable();
            // subjects= ['name'= name, 'reward'= rewards(parcentage/marks/credit)]
            $table->json('subjects')->nullable();
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
        Schema::dropIfExists('institute_departments');
    }
}
