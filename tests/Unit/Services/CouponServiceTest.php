<?php

namespace Tests\Unit;

use App\Client;
use App\Coupon;
use App\Offer;
use App\Services\CouponService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CouponServiceTest extends TestCase
{

    use DatabaseMigrations;

    public function test_coupon_token_generated_is_unique(){
        /** @var $coupon Coupon*/
        $client = factory(Client::class)->create();
        $offer = factory(Offer::class)->create();
        $cfake = factory(Coupon::class)->create(['client_id' => $client->id, 'offer_id' => $offer->id, 'validation_token' => 'ABC123']);

        $service = \Mockery::mock(CouponService::class . '[generateString]')->makePartial();
        $service->shouldAllowMockingProtectedMethods();
        $service->shouldReceive("generateString")->with(6)->once()->andReturn($cfake->validation_token);
        $service->shouldReceive("generateString")->with(6)->passthru();
        $coupon = new Coupon();
        $coupon->generateToken($service);
        $token = $coupon->validation_token;
        $this->assertNotEquals($token,  $cfake->validation_token);
    }

}
