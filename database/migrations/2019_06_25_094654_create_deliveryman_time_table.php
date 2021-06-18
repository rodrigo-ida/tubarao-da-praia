<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliverymanTimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveryman_time', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->integer('order_id')->unsigned();
            $table->integer('deliveryman_id')->unsigned();
            $table->foreign('deliveryman_id')->references('id')->on('users');
            $table->foreign('order_id')->references('id')->on('orders');
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
        //
    }
}
