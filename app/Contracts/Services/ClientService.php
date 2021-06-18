<?php
/**
 * Created by PhpStorm.
 * User: andre.merlo
 * Date: 18/10/2017
 * Time: 17:12
 */

namespace App\Contracts\Services;


interface ClientService
{
    public function generateUniqueLoginToken();
}