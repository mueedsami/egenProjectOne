<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Sepetiniz boş!');
        }

        return view('checkout', compact('cart'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Sepetiniz boş!');
        }

        // Create order
        $order = Order::create([
            'user_id' => 1, // static for now
            'order_number' => uniqid('ORD-'),
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'subtotal' => collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']),
            'total_amount' => collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']),
        ]);

        // Create order items
        foreach ($cart as $id => $details) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'name_snapshot' => $details['name'],
                'price_snapshot' => $details['price'],
                'quantity' => $details['quantity'],
                'total_price' => $details['price'] * $details['quantity'],
            ]);
        }

        session()->forget('cart');
        return redirect()->route('home')->with('success', 'Sipariş başarıyla oluşturuldu!');
    }
}
