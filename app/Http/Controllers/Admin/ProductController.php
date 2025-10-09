<?php

namespace App\Models;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Controller;
use App\Models\{Product, ProductImage, Category, Brand};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $q = $request->input('q');
        $products = Product::with(['category','brand','images'])
            ->when($q, fn($query) =>
                $query->where('name','like',"%{$q}%")->orWhere('sku','like',"%{$q}%")
            )
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        return view('admin.products.index', compact('products','q'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|max:255',
            'slug'        => 'nullable|max:255|unique:products,slug',
            'short_description' => 'nullable|max:255',
            'description' => 'nullable',
            'price'       => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'sku'         => 'nullable|max:100',
            'brand_id'    => 'nullable|exists:brands,id',
            'category_id' => 'nullable|exists:categories,id',
            'stock_qty'   => 'required|integer|min:0',
            'is_active'   => 'sometimes|boolean',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']).'-'.Str::random(6);
        $data['is_active'] = $request->boolean('is_active');

        $product = Product::create($data);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            ProductImage::create([
                'product_id' => $product->id,
                 'image_url'  => $path,
                'is_primary' => true,
                'sort_order' => 0,
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $brands     = Brand::orderBy('name')->get();
        $product->load('images');
        return view('admin.products.edit', compact('product','categories','brands'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'        => 'required|max:255',
            'slug'        => 'nullable|max:255|unique:products,slug,'.$product->id,
            'short_description' => 'nullable|max:255',
            'description' => 'nullable',
            'price'       => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'sku'         => 'nullable|max:100',
            'brand_id'    => 'nullable|exists:brands,id',
            'category_id' => 'nullable|exists:categories,id',
            'stock_qty'   => 'required|integer|min:0',
            'is_active'   => 'sometimes|boolean',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $data['slug'] = $data['slug'] ?? $product::slug($data['name']).'-'.$product->id;
        $data['is_active'] = $request->boolean('is_active');

        $product->update($data);

        if ($request->hasFile('image')) {
            // unset current primary
            ProductImage::where('product_id',$product->id)->update(['is_primary' => false]);

            $path = $request->file('image')->store('products', 'public');
            ProductImage::create([
                'product_id' => $product->id,
                'image_url'  => $path,
                'is_primary' => true,
                'sort_order' => 0,
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // remove images from disk
        foreach ($product->images as $img) {
            if ($img->image_url && Storage::disk('public')->exists($img->image_url)) {
                Storage::disk('public')->delete($img->image_url);
            }
            $img->delete();
        }

        $product->delete();
        return redirect()->route('admin.products.index')->with('success','Product deleted');
    }

    






}