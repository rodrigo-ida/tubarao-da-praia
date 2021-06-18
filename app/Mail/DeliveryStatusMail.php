<?php

namespace App\Mail;

use App\Order;
use App\OrderProduct;
use App\Avaliation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeliveryStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Order
     */
    private $order;

    private $ava;

    /**
     * Create a new message instance.
     *
     * @return void
     
    public function __construct(Order $order, Avaliation $ava)
    {
        $this->order = $order;
        $this->ava   = $ava;
    }

  
     * Build the message.
     *
     * @return $this
     
    public function build()
    {
        
        return $this->from(config('mail.from'))->subject('Tubarão da Praia Delivery')->view('emails.status', ['order' => $this->order, 'ava' => $this->ava]);
    }*/



     public function __construct(Order $order)
    {
        $this->order = $order;
       
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        return $this->from(config('mail.from'))->subject('Tubarão da Praia Delivery')->view('emails.status', ['order' => $this->order]);
    }
}
