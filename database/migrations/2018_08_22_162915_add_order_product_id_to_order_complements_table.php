<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderProductIdToOrderComplementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_complements', function (Blueprint $table) {
            $table->integer('order_product_id')->unsigned()->nullable();

            $table->foreign('order_product_id')->references('id')->on('order_products')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_complements', function (Blueprint $table) {
            //
        });
    }
}
