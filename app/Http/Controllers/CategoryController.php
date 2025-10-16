<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        // Fetch all parent categories (with their children)
        $categories = Category::with('children')
            ->whereNull('parent_id')
            ->orderBy('id')
            ->get();

        return view('categories', compact('categories'));
    }
    
    public function show(Request $request, $slug)
    {
    // Get main category + subcategories
    $category = Category::where('slug', $slug)
        ->with('children')
        ->firstOrFail();

    // Check if user clicked a subcategory
    $selectedSubcategorySlug = $request->query('sub');
    $selectedSubcategory = null;

    if ($selectedSubcategorySlug) {
        $selectedSubcategory = $category->children->where('slug', $selectedSubcategorySlug)->first();
    }

    // Build list of category IDs to filter products
    if ($selectedSubcategory) {
        $categoryIds = [$selectedSubcategory->id];
    } else {
        $categoryIds = collect([$category->id])->merge($category->children->pluck('id'))->toArray();
    }

    // Fetch products for selected category/subcategory
    $products = \App\Models\Product::whereIn('category_id', $categoryIds)
        ->with('images')
        ->latest()
        ->paginate(12)
        ->withQueryString(); // retain ?sub param during pagination

    return view('category.show', compact('category', 'products', 'selectedSubcategory'));
    }

}
