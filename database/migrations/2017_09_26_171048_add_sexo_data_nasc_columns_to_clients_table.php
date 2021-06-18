<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSexoDataNascColumnsToClientsTable extends Migration
{
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->date('data_nasc')->default('0000-00-00');
            $table->enum('sexo', ['Masculino', 'Feminino'])->default('Masculino');
        });
    }

    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['data_nasc', 'sexo']);
        });
    }
}
