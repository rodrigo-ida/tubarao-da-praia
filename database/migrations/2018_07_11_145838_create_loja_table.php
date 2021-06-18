<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLojaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loja', function(Blueprint $table){
            $table->increments('id');
            $table->string('nome_loja');
            $table->string('whatsapp_loja')->unique()->nullable();
            $table->string('telefone_loja')->unique()->nullable();
            $table->string('email_loja')->unique()->nullable();
            $table->string('cep_loja');
            $table->string('estado_loja');
            $table->string('cidade_loja');
            $table->string('bairro_loja');
            $table->string('logradouro_loja');
            $table->string('numero_loja');
            $table->string('facebook_loja');
            $table->string('site_loja');
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
        Schema::table('loja', function(Blueprint $table){
            $table->dropIfExists('loja');
        });
    }
}
