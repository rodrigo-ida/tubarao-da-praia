<?php

use Illuminate\Database\Seeder;

class OffersTableSeeder extends Seeder
{

    /**
     * @var int
     */
    private $number = 1;

    public function next($increments = true)
    {
        if ($increments) {
            return $this->number++;
        } else {
            return $this->number;
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $expires = Carbon\Carbon::today()->subDay();
        factory(\App\Offer::class, 4)->create([
            'begins_at' => null,
            'expires_at' => $expires,
            'titulo' => function() {
                return 'Offer ' . $this->next(false);
            },
            'image_filename' => function() {
                return 'promo' . $this->next() . '.jpg';
            }
            ,
        ]);

        $expires = Carbon\Carbon::today()->addDays(4);
        $begins = Carbon\Carbon::today();
        factory(\App\Offer::class, 4)->create([
            'begins_at' => $begins,
            'expires_at' => $expires,
            'titulo' => function() {
                return 'Offer ' . $this->next(false);
            },
            'image_filename' => function() {
                return 'promo' . $this->next() . '.jpg';
            },
            'coupon_limit' => 5,
        ]);
    }
}
