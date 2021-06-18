<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_config', function(Blueprint $table){
            $table->increments('id');
            $table->time('config_time');
            $table->date('config_date');
            $table->integer('config_loja_id')->unsigned();
            $table->enum('config_status', ['0', '1']);
            $table->timestamps();

            $table->foreign('config_loja_id')->references('id')->on('loja');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('delivery_config');
    }
}
