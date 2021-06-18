<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionBannerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotion_banner', function(Blueprint $table){
            $table->increments('id');
            $table->string('promo_banner_pic_src');
            $table->integer('promo_banner_prod_id')->unsigned();
            $table->integer('promo_banner_day');
            $table->integer('promo_banner_loja_id')->unsigned();

            $table->foreign('promo_banner_prod_id')->references('id')->on('product');
            $table->foreign('promo_banner_loja_id')->references('id')->on('loja');
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
