<?php

namespace App\Mail;

use App\User;
use App\ForgotPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class resetPassword extends Mailable
{
    use Queueable, SerializesModels;

    private $client;

    private $fp;

    private $hash;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $fgP, string $hash, $user)
    {
        $this->fp = $fgP;

        $this->client = $user;

        $this->hash = $hash;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from'))->subject('Tubarão da Praia Delivery')->view('emails.forget_password', ['fp' => $this->fp, 'client' => $this->client, 'hash' => $this->hash]);
    }
}
