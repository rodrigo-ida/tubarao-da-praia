<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvaliationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avaliation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('avaliation_note')->nullable();
            $table->text('avaliation_desc')->nullable();
            $table->integer('client_id')->unsigned()->nullable();
            $table->text('token')->nullable();
            $table->enum('avaliation_status', ['0', '1'])->nullable();

            $table->foreign('client_id')->references('id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('avaliation', function (Blueprint $table) {
            //
        });
    }
}
