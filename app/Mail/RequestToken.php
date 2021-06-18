<?php

namespace App\Mail;

use App\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RequestToken extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Client
     */
    private $cliente;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Client $cliente)
    {
        $this->cliente = $cliente;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from'))
            ->subject('Solicitação de link de acesso')
            ->view('emails.request_token', ['cliente' => $this->cliente]);
    }
}
