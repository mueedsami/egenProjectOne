<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();

        return response()->json([
            'success' => true,
            'count' => $categories->count(),
            'data' => $categories
        ]);
    }

    public function show(Request $request, $slug)
    {
        $category = Category::with('children')->where('slug', $slug)->first();

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Category not found'], 404);
        }

        $selectedSubcategorySlug = $request->query('sub');
        $selectedSubcategory = $selectedSubcategorySlug
            ? $category->children->where('slug', $selectedSubcategorySlug)->first()
            : null;

        $categoryIds = $selectedSubcategory
            ? [$selectedSubcategory->id]
            : collect([$category->id])->merge($category->children->pluck('id'))->toArray();

        $products = Product::with('images')->whereIn('category_id', $categoryIds)->latest()->paginate(12);

        return response()->json([
            'success' => true,
            'category' => $category,
            'subcategory' => $selectedSubcategory,
            'products' => $products
        ]);
    }
}
