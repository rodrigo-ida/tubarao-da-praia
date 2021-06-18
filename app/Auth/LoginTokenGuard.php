<?php
/**
 * Created by PhpStorm.
 * User: andre.merlo
 * Date: 29/08/2017
 * Time: 15:35
 */

namespace App\Auth;

use App\Client;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Auth\SessionGuard;

class LoginTokenGuard extends SessionGuard
{

    private $forceLogout = false;

    public function user()
    {
        if ($this->forceLogout) {
            return parent::user();
        }

        $user = parent::user();

        $loginToken = $this->getLoginToken();
        if (!is_null($loginToken)) {

            $user = $this->userFromLoginToken($loginToken);

            if ($user) {
                $this->login($user, false);
            } else {
                $this->forceLogout();
            }
        }

        return $this->user = $user;
    }

    public function getLoginToken()
    {
        return $this->getRequest()->get('login_token', null);
    }

    protected function userFromLoginToken($loginToken)
    {
        $user = $this->provider->retrieveByCredentials(
            [$this->getLoginTokenName() => $loginToken]
        );

        return $user;
    }

    /**
     * @return string
     */
    protected function getLoginTokenName()
    {
        if ($this->provider instanceof EloquentUserProvider) {
            $model = $this->provider->createModel();
            if (method_exists($model, 'getLoginTokenName')) {
                return $model->getLoginTokenName();
            }
        }

        return 'login_token';
    }

    private function forceLogout() 
    {
        $this->forceLogout = true;
        $this->logout();
        $this->forceLogout = false;
    }

}