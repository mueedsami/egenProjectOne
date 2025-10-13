<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(Product::all());
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return response()->json($product);
    }
}
