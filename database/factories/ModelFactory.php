<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});


/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Client::class, function (Faker\Generator $faker) {

    return [
        'nome' => $faker->name,
        'whatsapp' => (strlen($cell = $faker->phoneNumber) < 15 ? (substr($cell, 0, 5) . '9' . substr($cell, 5)) : $cell),
        'email' => $faker->unique()->safeEmail,
        'cep' => $faker->postcode,
        'estado' => $faker->randomElement(['SP', 'RJ', 'MG']),
        'cidade' => $faker->city,
        'bairro' => $faker->city,
        'logradouro' => $faker->streetName,
        'numero' => $faker->randomNumber(3),
        'complemento' => $faker->randomElement(['Fundos', 'Frente', 'Sobreposta', null]),
        'sexo' => $faker->randomElement(['Masculino', 'Feminino']),
        'data_nasc' => $faker->date('Y-m-d'),
        'login_token' => str_random(60),
    ];

});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Offer::class, function (Faker\Generator $faker) {

    return [
        'titulo' => $faker->text(80),
        'descricao' => $faker->sentence(15),
        'begins_at' => \Carbon\Carbon::today(),
        'expires_at' => \Carbon\Carbon::today()->addDay(),
        'active' => true,
        'coupon_limit' => 0,
    ];

});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Coupon::class, function (Faker\Generator $faker) {

    return [
        'validation_token' => str_random(6),
    ];

});