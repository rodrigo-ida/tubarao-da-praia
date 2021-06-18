<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProductVariationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_variation', function (Blueprint $table) {
            $table->float('prod_var_promo_price');
            $table->enum('prod_var_promo_day', ['0','1','2','3','4','5','6']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_variation', function (Blueprint $table) {
            $table->dropColumn('prod_var_promo_price');
            $table->dropColumn('prod_var_promo_day');
        });
    }
}
