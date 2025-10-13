<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlacedMail;
use Illuminate\Support\Facades\Log;

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

        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Sipariş vermek için giriş yapınız.');
        }

        $subtotal = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);

        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => uniqid('ORD-'),
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'subtotal' => $subtotal,
            'total_amount' => $subtotal,
        ]);

        foreach ($cart as $productId => $details) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'name_snapshot' => $details['name'],
                'price_snapshot' => $details['price'],
                'quantity' => $details['quantity'],
                'total_price' => $details['price'] * $details['quantity'],
            ]);
        }

        try {
            Mail::to($user->email)->send(new OrderPlacedMail($order->fresh('items')));
            Log::info('✅ Order mail sent successfully', ['to' => $user->email]);
        } catch (\Throwable $e) {
            Log::error('❌ Mail send failed', ['error' => $e->getMessage()]);
        }

        session()->forget('cart');

        return redirect()->route('home')->with('success', 'Sipariş başarıyla oluşturuldu! Onay e-postası gönderildi.');
    }
}
