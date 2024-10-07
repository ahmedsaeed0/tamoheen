<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePassengersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passengers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('trip_id')->nullable();
            $table->unsignedBigInteger('booking_user_id')->nullable();
            $table->unsignedBigInteger('trip_booking_id')->nullable();
            $table->tinyInteger('title')->nullable();
            $table->string('name')->nullable();
            $table->tinyInteger('identity_type')->nullable();
            $table->string('identity_number')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('trip_id')->references('id')->on('trips');
            $table->foreign('booking_user_id')->references('id')->on('users');
            $table->foreign('trip_booking_id')->references('id')->on('trip_bookings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('passengers');
    }
}
