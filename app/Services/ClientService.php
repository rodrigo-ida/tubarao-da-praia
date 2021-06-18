<?php

namespace App\Services;

use App\Client;
use App\Contracts\Services\ClientService as ClientServiceContract;
use RandomLib\Factory;

class ClientService implements ClientServiceContract
{

    private $generator;

    public function __construct()
    {
        $factory = new Factory();
        $this->generator = $factory->getLowStrengthGenerator();
    }

    public function generateUniqueLoginToken()
    {
        $token = null;
        do {
            $newToken = $this->generateLoginToken();
            if (!$this->loginTokenExists($newToken)) {
                $token = $newToken;
            }
        } while ($token == null);

        return $token;
    }

    protected function generateLoginToken()
    {
        $length = 60;
        $chars = 'abcdefghijklmnopqrstuvxwyzABCDEFGHIJKLMNOPQRSTUVXWYZ0123456789';
        $token = $this->generator->generateString($length, $chars);
        return $token;
    }

    protected function loginTokenExists($token)
    {
        return Client::whereLoginToken($token)->count() > 0;
    }
}