<?php

use Illuminate\Database\Seeder;

class CouponsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $client = \App\Client::find(1);
        $offer = \App\Offer::find(1);

        //Cupom utilizado
        $c = new \App\Coupon();
        $c->validation_token = '111111';
        $c->validation_date = \Carbon\Carbon::now();
        $c->client()->associate($client);
        $c->offer()->associate($offer);
        $c->save();

        //Cupom livre
        $c = new \App\Coupon();
        $c->validation_token = '222222';
        $c->validation_date = null;
        $c->client()->associate($client);
        $c->offer()->associate($offer);
        $c->save();
    }
}
