<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveRequiredFromSexoToClientsTable extends Migration
{
    public function up()
    {
        $connection = config('database.default');

        if ($connection == 'sqlite_testing') {
            Schema::table('clients', function (Blueprint $table) {
                $table->dropColumn('sexo');
            });

            Schema::table('clients', function (Blueprint $table) {
                $table->enum('sexo', ['Masculino', 'Feminino'])->nullable();
            });
            return;
        }

        \Illuminate\Support\Facades\DB::statement("ALTER TABLE clients CHANGE COLUMN sexo sexo ENUM('Masculino', 'Feminino')");

    }

    public function down()
    {
        $connection = config('database.default');

        if ($connection == 'sqlite_testing') {

            Schema::table('clients', function (Blueprint $table) {
                $table->dropColumn('sexo');
            });

            Schema::table('clients', function (Blueprint $table) {
                $table->enum('sexo', ['Masculino', 'Feminino'])->default('Masculino');
            });

            return;
        }

        \Illuminate\Support\Facades\DB::statement("ALTER TABLE clients CHANGE COLUMN sexo sexo ENUM('Masculino', 'Feminino') NOT NULL");
    }
}
