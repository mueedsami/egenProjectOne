<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderPlacedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order)
    {
        // Load relationships so email templates can use them
        $this->order = $order->load('items.product', 'user');
    }

    /**
     * Build the message.
     */
    public function build()
    {
        // ✅ Generate PDF invoice
        $pdf = Pdf::loadView('orders.invoice', [
            'order' => $this->order
        ]);

        // ✅ Build email with markdown + PDF attachment
        return $this->from('madesticbd@gmail.com', 'Deshio Orders')
                    ->subject('Order Confirmation — ' . $this->order->order_number)
                    ->markdown('emails.orders.placed', [
                        'order' => $this->order,
                    ])
                    ->attachData(
                        $pdf->output(),
                        'invoice-' . $this->order->order_number . '.pdf',
                        ['mime' => 'application/pdf']
                    );
    }
}
