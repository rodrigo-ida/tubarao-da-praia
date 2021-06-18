<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentMethodsLojaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_methods_loja', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('payment_method_loja_id')->unsigned();
            $table->text('payment_method_ids');
            $table->foreign('payment_method_loja_id')->references('id')->on('loja');
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
        Schema::dropIfExists('payment_methods_loja');
    }
}
