<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(\App\User::class)->create([
            'name' => 'Administrador',
            'email' => 'user@user.com',
            'password' => bcrypt('secret'),
        ]);

        factory(\App\User::class)->create([
            'name' => 'Ótima Ideia',
            'email' => 'otimaideia@otimaideia.com.br',
            'password' => bcrypt('12qwaszx!@#$'),
        ]);

        factory(\App\User::class)->create([
            'name' => 'Administrador',
            'email' => 'descontos@tubaraodapraia.com.br',
            'password' => bcrypt('cupom385!'),
        ]);

        factory(\App\User::class, 10)->create();

    }
}
