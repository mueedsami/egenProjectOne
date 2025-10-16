<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // Optional filter (by category or subcategory)
        $categorySlug = $request->query('category');

        // Fetch categories for sidebar (with children)
        $categories = Category::with('children')
            ->whereNull('parent_id')
            ->orderBy('id')
            ->get();

        // Fetch products (filtered or all)
        $query = Product::with(['images', 'category'])
            ->orderBy('created_at', 'desc');

        if ($categorySlug) {
            $query->whereHas('category', fn($q) => $q->where('slug', $categorySlug));
        }

        $products = $query->paginate(20);

        return view('shop', compact('categories', 'products', 'categorySlug'));
    }
}
