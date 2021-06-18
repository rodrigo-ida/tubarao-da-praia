<?php

namespace App\Mail;

use App\Order;
use App\OrderProduct;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeliveryMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Order
     */
    private $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
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
        $products = OrderProduct::select('*')

        ->with(['getOrderProducts'])->get()

        ->where('order_id', '=', $this->order->id);

        return $this->from(config('mail.from'))->subject('Tubarão da Praia Delivery')->view('emails.pedido', ['order' => $this->order, 'products' => $products ]);
    }
}
