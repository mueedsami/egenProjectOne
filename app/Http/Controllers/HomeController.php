<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $heroBanners = [
            ['image' => 'hero1.jpg', 'title' => 'Deshio Winter Collection', 'subtitle' => 'Warm. Minimal. Made in Bangladesh.', 'link' => '/products'],
            ['image' => 'hero2.jpg', 'title' => 'Heritage Craft Collection', 'subtitle' => 'Redefine your wardrobe with heritage patterns.', 'link' => '/products'],
        ];

        // ✅ Load categories dynamically with children & products
        $categories = Category::with(['children.products.images'])
            ->whereNull('parent_id')
            ->orderBy('id')
            ->get();

        $promoBanners = [
            ['image' => 'promo1.jpg', 'title' => 'Up to 40% Off', 'subtitle' => 'Limited Time Offer', 'link' => '/products'],
            ['image' => 'promo2.jpg', 'title' => 'New Arrivals', 'subtitle' => 'Explore the Latest Looks', 'link' => '/products'],
        ];

        // ✅ Fetch latest products with images
        $products = Product::with('images')->latest()->take(10)->get();

        return view('home', compact('heroBanners', 'categories', 'promoBanners', 'products'));
    }
}
