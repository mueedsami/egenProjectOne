<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPlacedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order->load('items.product', 'user');
    }

    public function build()
    {
        return $this
            ->subject('Order Confirmation: '.$this->order->order_number)
            ->markdown('emails.orders.placed', [
                'order' => $this->order,
            ]);
    }
}
