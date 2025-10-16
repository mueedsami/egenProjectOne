<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlacedMail;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return response()->json([
                'success' => false,
                'message' => 'Cart is empty'
            ], 400);
        }

        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'You must be logged in to place an order'
            ], 401);
        }

        $subtotal = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);

        // ✅ Create order record
        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => uniqid('ORD-'),
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'subtotal' => $subtotal,
            'total_amount' => $subtotal,
        ]);

        // ✅ Save each cart item
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

        // ✅ Try sending confirmation email
        try {
            Mail::to($user->email)->send(new OrderPlacedMail($order->fresh('items')));
            Log::info('✅ Order mail sent successfully', ['to' => $user->email]);
        } catch (\Throwable $e) {
            Log::error('❌ Order mail send failed', ['error' => $e->getMessage()]);
        }

        // ✅ Clear cart after order
        session()->forget('cart');

        return response()->json([
            'success' => true,
            'message' => 'Order placed successfully! Confirmation email sent.',
            'order_id' => $order->id,
            'order_number' => $order->order_number
        ]);
    }
}
