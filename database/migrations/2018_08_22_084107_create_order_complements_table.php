<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderComplementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_complements', function(Blueprint $table){
            $table->increments('id');
            $table->integer('id_prod')->unsigned()->nullable();
            $table->integer('id_comp')->unsigned()->nullable();
            $table->float('price_comp');
            $table->integer('qtd_comp');

            $table->foreign('id_prod')->references('id')->on('product')->nullable();
            $table->foreign('id_comp')->references('id')->on('product_complements')->nullable();
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
