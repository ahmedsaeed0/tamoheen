<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('city_from_id')->nullable();
            $table->unsignedBigInteger('city_to_id')->nullable();
            $table->unsignedBigInteger('car_id')->nullable();
            $table->string('title')->nullable();
            $table->string('title_arabic')->nullable();
            $table->string('title_urdu')->nullable();
            $table->string('description')->nullable();
            $table->string('description_arabic')->nullable();
            $table->string('description_urdu')->nullable();
            $table->dateTime('date')->nullable();
            $table->string('price_per_person')->nullable();
            $table->string('price_per_bag')->nullable();
            $table->string('pickup_location')->nullable();
            $table->integer('number_of_person')->nullable();
            $table->integer('number_of_bag')->nullable();
            $table->integer('available_of_person')->nullable();
            $table->integer('available_of_bag')->nullable();
            $table->tinyInteger('type')->nullable();
            $table->unsignedBigInteger('feature_id')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->string('start_point')->nullable();
            $table->string('end_point')->nullable();
            $table->double('discount')->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('city_from_id')->references('id')->on('cities');
            $table->foreign('city_to_id')->references('id')->on('cities');
            $table->foreign('car_id')->references('id')->on('cars');
            $table->foreign('feature_id')->references('id')->on('features');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trips');
    }
}
