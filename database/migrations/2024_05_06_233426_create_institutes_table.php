<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstitutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institutes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('images')->nullable();
            $table->longText('description');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('SET NULL');
            $table->foreignId('institute_head')->nullable()->constrained('users')->onDelete('SET NULL');
            $table->json('admins')->nullable();
            $table->json('passkeys')->nullable();
            $table->json('emails')->nullable();
            $table->json('mobile_numbers')->nullable();
            $table->string('address_one')->nullable();
            $table->string('address_two')->nullable();
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
        Schema::dropIfExists('institutes');
    }
}
