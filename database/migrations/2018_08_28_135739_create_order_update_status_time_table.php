<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderUpdateStatusTimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_update_status_time', function(Blueprint $table){
            $table->increments('id');
            $table->integer('order_status_updated_id')->unsigned();
            $table->integer('order_user_updated_id')->unsigned();
            $table->string('order_status_name');

            $table->timestamps();

            $table->foreign('order_status_updated_id')->references('id')->on('orders');
            $table->foreign('order_user_updated_id')->references('id')->on('users');

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
