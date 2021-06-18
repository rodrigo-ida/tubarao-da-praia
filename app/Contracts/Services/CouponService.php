<?php
/**
 * Created by PhpStorm.
 * User: Leandro
 * Date: 18/10/2017
 * Time: 16:19
 */
namespace App\Contracts\Services;

interface CouponService
{
    public function generateToken();
}