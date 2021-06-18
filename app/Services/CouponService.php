<?php
/**
 * Created by PhpStorm.
 * User: Leandro
 * Date: 18/10/2017
 * Time: 16:22
 */

namespace App\Services;


use App\Coupon;
use RandomLib\Factory;

class CouponService implements \App\Contracts\Services\CouponService
{

    private $generator;

    public function __construct()
    {
        $factory = new Factory();
        $this->generator = $factory->getLowStrengthGenerator();
    }


    protected function generateString($size)
    {
        return $this->generator->generateString($size, 'ABCDEFGHIJKLMNOPQRSTUVXYWZ0123456789');
    }

    protected function checkOnDatabase($test)
    {
        return Coupon::whereValidationToken($test)->count();
    }


    public function generateToken()
    {
        $token = null;
        do {
            $test = $this->generateString(6);
            $count = $this->checkOnDatabase($test);
            if ($count <= 0) {
                $token = $test;
            }
        } while ($token == null);
        return $token;
    }
}