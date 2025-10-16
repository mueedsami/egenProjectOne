<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'success' => true,
            'cart' => session('cart', [])
        ]);
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);
        $quantity = $request->input('quantity', 1);

        $cart[$id] = [
            'name' => $product->name,
            'quantity' => ($cart[$id]['quantity'] ?? 0) + $quantity,
            'price' => $product->price,
            'image' => $product->image_url,
        ];

        session()->put('cart', $cart);
        return response()->json(['success' => true, 'cart' => $cart]);
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);

        return response()->json(['success' => true, 'cart' => $cart]);
    }
}
