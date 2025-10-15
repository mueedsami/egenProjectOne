<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        // HERO BANNERS (static demo for now)
        $heroBanners = [
            ['title' => 'Modern Heritage Wear', 'subtitle' => 'Crafted for every season', 'image' => 'banner1.jpg', 'link' => '/category/heritage'],
            ['title' => 'Minimal Winter Layers', 'subtitle' => 'Soft, warm & sustainable', 'image' => 'banner2.jpg', 'link' => '/category/winter'],
        ];

        // PROMO BANNERS (static demo)
        $promoBanners = [
            ['title' => 'Couple’s Edit', 'subtitle' => 'Perfectly matched styles', 'image' => 'banner3.jpg', 'link' => '/category/couples'],
            ['title' => 'Bangladeshi Roots', 'subtitle' => 'Tradition reimagined', 'image' => 'banner4.jpg', 'link' => '/category/heritage'],
        ];

        // MAIN CATEGORIES (only top-level)
        $categories = Category::whereNull('parent_id')
            ->with(['children' => function ($q) {
                $q->with(['products' => function ($q2) {
                    $q2->take(6)->with('images');
                }]);
            }])
            ->take(6)
            ->get();

        // NEW ARRIVALS
        $products = Product::with('images')
            ->inRandomOrder()
            ->take(12)
            ->get();

        return view('home', compact('heroBanners', 'promoBanners', 'categories', 'products'));
    }


    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('product', compact('product'));
    }
    public function homepage()
    {
        $categories = \App\Models\Category::whereNull('parent_id')
        ->with(['children.products.images'])
        ->get();

        return view('home', compact('categories'));
    }

}
