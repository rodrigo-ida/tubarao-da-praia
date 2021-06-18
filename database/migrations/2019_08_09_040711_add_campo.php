<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCampo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotion_banner', function (Blueprint $table) {
           $table->enum('promo_carrinho', ['0', '1']);
            $table->enum('promo_status', ['0', '1']);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promotion_banner', function (Blueprint $table) {
            //
        });
    }
}
