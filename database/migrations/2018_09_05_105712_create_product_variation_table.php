<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductVariationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variation', function(Blueprint $table){
            $table->increments('id');
            $table->string('prod_var_name');
            $table->integer('prod_id')->unsigned();
            $table->float('prod_var_price');
            $table->enum('prod_var_active', ['0', '1']);
            $table->integer('prod_var_promo_id')->unsigned();
            $table->enum('prod_var_status', ['0', '1', '2']);
            $table->timestamps();

            $table->foreign('prod_id')->references('id')->on('product');
            $table->foreign('prod_var_promo_id')->references('id')->on('product_promotions');
            
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
