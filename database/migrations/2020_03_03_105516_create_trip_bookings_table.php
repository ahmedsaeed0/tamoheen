<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('trip_id')->nullable();
            $table->integer('number_of_passengers')->nullable();
            $table->string('price')->nullable();
            $table->boolean('is_payment_complete')->default(false);
            $table->tinyInteger('status')->nullable();
            $table->string('check_in')->nullable();
            $table->string('check_out')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('trx_id')->nullable();
            $table->string('stc_ref_num')->nullable();
            $table->string('partner_price')->nullable();
            $table->double('card_price', 8, 2)->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('trip_id')->references('id')->on('trips');
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
        Schema::dropIfExists('trip_bookings');
    }
}
