<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use PDF; // dompdf

class OrderController extends Controller
{
    // Show user's orders
    public function index()
    {
        $orders = Order::with('items.product')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    // View single order details
    public function show(Order $order)
    {
        $this->authorize('view', $order);
        $order->load('items.product');
        return view('orders.show', compact('order'));
    }

    // Generate downloadable invoice
    public function invoice(Order $order)
    {
        $this->authorize('view', $order);
        $order->load('items.product', 'user');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('orders.invoice', compact('order'));
        return $pdf->download('invoice-' . $order->order_number . '.pdf');
    }
}
