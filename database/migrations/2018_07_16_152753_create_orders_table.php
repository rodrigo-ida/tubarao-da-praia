<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->float('order_total');
            $table->integer('order_prod_qtd');
            $table->float('order_tax_rate');
            $table->text('order_street');
            $table->integer('order_number');
            $table->text('order_neighborhood');
            $table->string('order_city', 100);
            $table->string('order_state', 100);
            $table->text('order_complement')->nullable();
            $table->text('order_reference')->nullable();
            $table->integer('order_status')->unsigned();
            $table->text('order_obs')->nullable();
            $table->integer('order_payment_method')->unsigned();
            $table->integer('order_client_id')->unsigned();
            $table->integer('order_loja_id')->unsigned();

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
        Schema::dropIfExists('orders');
    }
}
