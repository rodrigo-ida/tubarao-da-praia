<?php

namespace App\Mail;

use App\Coupon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CouponMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Coupon
     */
    private $cupom;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Coupon $cupom)
    {
        $this->cupom = $cupom;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        return $this->from(config('mail.from'))->subject('Clube de Desconto Tubarão da Praia -Aqui está o seu cupom')->view('emails.cupom', ['cupom' => $this->cupom]);
    }
}
