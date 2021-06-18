<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTaxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_tax', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_tax_cep_inicial', 9);
            $table->string('order_tax_cep_final', 9);
            $table->enum('order_tax_status', ['0', '1']);
            $table->integer('order_tax_loja_id')->unsigned();
            $table->float('order_tax_price')->nullable();
            $table->foreign('order_tax_loja_id')->references('id')->on('loja');
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
        Schema::dropIfExists('order_tax');
    }
}
