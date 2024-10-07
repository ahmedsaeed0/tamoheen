<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TripProductType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_product_type', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('trip_id')->nullable();
            $table->unsignedBigInteger('product_type_id')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('trip_id')->references('id')->on('trips');
            $table->foreign('product_type_id')->references('id')->on('product_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trip_product_type');
    }
}
