<?php

namespace App;

use App\Contracts\Services\CouponService;
use Illuminate\Database\Eloquent\Model;
use RandomLib\Factory;

class Coupon extends Model
{
    protected $fillable = ['validation_token', 'validation_date'];

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function offer(){
        return $this->belongsTo(Offer::class);
    }

    public function hasBeenUsed(){
        return $this->validation_date != null;
    }

    public function generateToken(CouponService $service)
    {
        if ($service) {
            $this->validation_token = $service->generateToken();
        }
    }
}
