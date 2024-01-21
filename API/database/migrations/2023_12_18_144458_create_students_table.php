<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            //$table->uuid('id')->default(DB::raw('(UUID())'))->index();
            $table->id();
            $table->string('name');
            $table->string('gender');
            $table->string('examno');
            $table->string('email');
            $table->string('yearOfStudy');
            $table->string('fingerStatus')->default('FALSE'); //whether fingerprint is registered or not
            $table->string('status')->default('FALSE');//Attendance Status
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
        Schema::dropIfExists('students');
    }
};
