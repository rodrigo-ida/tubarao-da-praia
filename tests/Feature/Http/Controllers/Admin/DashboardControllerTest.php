<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Client;
use App\Coupon;
use App\Offer;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        $user = factory(User::class)->create();
        $this->actingAs($user);
    }

    /**
     * Test return format for requests on get data for graph component that shows creation and uses of coupons
     */
    public function test_json_format_for_coupon_uses_and_creation_graph()
    {
        $response = $this->get(route('admin.dashboard.data.coupon'));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'interval' => [
                    'start',
                    'end',
                ],
                'items' => [
                    '*' => [
                        'timestamp',
                        'totals' => [
                            'created',
                            'used'
                        ]
                    ]
                ],
            ]
        ]);
    }

    /**
     * Check if returned data for "coupon uses and creation" totals is correct
     */
    public function test_data_for_coupon_uses_and_creation_totals()
    {

        // make data to be used on coupons
        $today = Carbon::today();
        $fifteenDaysBefore = Carbon::today()->subDays(15);
        $client = factory(Client::class)->create();
        $offer = factory(Offer::class)->create();

        // create 15 coupons
        /* @var $coupons Collection */
        $coupons = factory(Coupon::class, 15)->create([
            'client_id' => $client->id,
            'offer_id' => $offer->id,
            'created_at' => $fifteenDaysBefore
        ]);

        // set validation_date on 5 coupons
        $coupons = $coupons->slice(0, 5);
        foreach ($coupons as $coupon) {
            $coupon->validation_date = $today;
            $coupon->save();
        }

        $response = $this->get(route('admin.dashboard.data.coupon'));
        $response->assertStatus(200);
        $response->assertJsonFragment(
            [
                'items' => [
                    [
                        'timestamp' => $fifteenDaysBefore->timestamp,
                        'totals' => [
                            'created' => 15,
                            'used' => 0
                        ]
                    ],
                    [
                        'timestamp' => $today->timestamp,
                        'totals' => [
                            'created' => 0,
                            'used' => 5
                        ]
                    ]
                ]
            ]
        );
    }

}
