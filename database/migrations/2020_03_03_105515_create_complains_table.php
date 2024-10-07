<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complains', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('trip_id')->nullable();
            $table->unsignedBigInteger('complain_from_id')->nullable();
            $table->unsignedBigInteger('complain_to_id')->nullable();
            $table->string('title')->nullable();
            $table->string('title_arabic')->nullable();
            $table->string('title_urdu')->nullable();
            $table->string('description')->nullable();
            $table->string('description_arabic')->nullable();
            $table->string('description_urdu')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('trip_id')->references('id')->on('trips');
            $table->foreign('complain_from_id')->references('id')->on('users');
            $table->foreign('complain_to_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('complains');
    }
}
