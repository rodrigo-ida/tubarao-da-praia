<?php

namespace App\Listeners;

use App\Client;
use Illuminate\Auth\Events\Login;

class LoginListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user = $event->user;

        if ($user instanceof Client) {
            $user->verified_email = true;
            $user->last_login = new \DateTime;
            $user->save();
        }
    }
}
