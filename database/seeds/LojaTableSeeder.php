<?php

use Illuminate\Database\Seeder;

class LojaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('loja')->insert([
            'nome_loja'         => 'mudar nome',
            'whatsapp_loja'     => '',
            'telefone_loja'     => '',
            'email_loja'        => 'mudaraqui@mudar.com',
            'cep_loja'          => 'colocar cep',
            'estado_loja'       => 'colocar estado',
            'cidade_loja'       => 'colocar cidade',
            'bairro_loja'       => 'colocar bairro',
            'logradouro_loja'   => 'colocar endereço',
            'numero_loja'       => 'colocar numero',
            'facebook_loja'     => 'colocar facebook',
            'site_loja'         => 'colocar site',
            'status'            => '0'
            ]);
    }
}
