<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
        $q = $request->input('q');

        $products = Product::with(['category', 'brand', 'images'])
            ->when($q, fn($query) =>
                $query->where('name', 'like', "%{$q}%")
                      ->orWhere('sku', 'like', "%{$q}%")
            )
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        return view('admin.products.index', compact('products', 'q'));
    }

    /**
     * Show create form.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();

        return view('admin.products.create', compact('categories', 'brands'));
    }

    /**
     * Store new product.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'nullable|max:255|unique:products,slug',
            'short_description' => 'nullable|max:255',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'sku' => 'nullable|max:100',
            'brand_id' => 'nullable|exists:brands,id',
            'category_id' => 'nullable|exists:categories,id',
            'stock_qty' => 'required|integer|min:0',
            'is_active' => 'sometimes|boolean',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']) . '-' . Str::random(5);
        $data['is_active'] = $request->boolean('is_active');

        $product = Product::create($data);

        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $imageFile) {
                $path = $imageFile->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $path,
                    'is_primary' => $index === 0, // first image = primary
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Edit product form.
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();
        $product->load('images');

        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    /**
     * Update product.
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'nullable|max:255|unique:products,slug,' . $product->id,
            'short_description' => 'nullable|max:255',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'sku' => 'nullable|max:100',
            'brand_id' => 'nullable|exists:brands,id',
            'category_id' => 'nullable|exists:categories,id',
            'stock_qty' => 'required|integer|min:0',
            'is_active' => 'sometimes|boolean',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']) . '-' . $product->id;
        $data['is_active'] = $request->boolean('is_active');

        $product->update($data);

        // New image uploads (keep old ones)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $imageFile) {
                $path = $imageFile->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $path,
                    'is_primary' => $product->images()->count() == 0 && $index === 0,
                    'sort_order' => $product->images()->count() + $index,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Delete product and its images.
     */
    public function destroy(Product $product)
    {
        foreach ($product->images as $img) {
            if ($img->image_url && Storage::disk('public')->exists($img->image_url)) {
                Storage::disk('public')->delete($img->image_url);
            }
            $img->delete();
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
