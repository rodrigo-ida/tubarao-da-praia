<?php

namespace Tests\Unit;

use App\Offer;
use Carbon\Carbon;
use Tests\TestCase;

class OfferTest extends TestCase
{

    /**
     *  Checks if the offer is active.
     */
    public function teste_if_is_active(){
        $offer = new Offer();
        $this->assertFalse($offer->isActive());
        $offer->active = true;
        $this->assertTrue($offer->isActive());
    }

    /**
     *  Checks if the client can use the offer.
     */
    public function test_if_can_use_offer()
    {
        $offer = new Offer();
        $this->assertFalse($offer->canClientUseIt());
        $offer->active = true;
        $this->assertTrue($offer->canClientUseIt());
        $offer->begins_at = Carbon::today()->addDay();
        $this->assertFalse($offer->canClientUseIt());
        $offer->begins_at = Carbon::today();
        $this->assertTrue($offer->canClientUseIt());
        $offer->expires_at = Carbon::today()->subDay(1);
        $this->assertFalse($offer->canClientUseIt());
        $offer->expires_at = Carbon::today()->addDay();
        $this->assertTrue($offer->canClientUseIt());
    }

    /**
     * Checks if image url is null on Offer object creation. After set the image_filename attribute, checks if him is not null and results are as the expected.
     */
    public function test_image_url(){
        $offer = new Offer();
        $this->assertNull($offer->getImageURL());
        $offer->image_filename = 'dummy.jpg';
        $this->assertNotNull($offer->getImageURL());
        $this->assertEquals(asset('storage/') . '/' . Offer::$images_storage_path . '/' . $offer->image_filename, $offer->getImageURL());
    }

    /**
     * Checks if image path is null on Offer object creation. After set the image_filename attribute, checks if him is not null and results are as the expected.
     */
    public function test_image_path(){
        $offer = new Offer();
        $this->assertNull($offer->getImagePath());
        $offer->image_filename = 'dummy.jpg';
        $this->assertNotNull($offer->getImagePath());
        $this->assertEquals(Offer::$images_storage_path . '/' . $offer->image_filename, $offer->getImagePath());
    }

    /**
     * Checks if offer object has a image
     */
    public function test_has_image(){
        $offer = new Offer();
        $this->assertFalse($offer->hasImage());
        $offer->image_filename = 'dummy.jpg';
        $this->assertEquals('dummy.jpg', $offer->image_filename);
        $this->assertTrue($offer->hasImage());
    }


}
