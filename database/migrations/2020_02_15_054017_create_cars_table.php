<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name')->nullable();
            $table->string('name_arabic')->nullable();
            $table->string('name_urdu')->nullable();
            $table->integer('capacity_of_person')->nullable();
            $table->integer('capacity_of_bag')->nullable();
            $table->string('sequence_number')->nullable();
            $table->string('plate_letter_right')->nullable();
            $table->string('plate_letter_middle')->nullable();
            $table->string('plate_letter_left')->nullable();
            $table->string('plate_number')->nullable();
            $table->integer('plate_type')->default(1);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
}
