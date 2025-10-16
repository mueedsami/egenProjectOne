@csrf
<div class="bg-white rounded-xl border border-stone-200 shadow-sm p-8">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- Product Name --}}
    <div>
      <label class="block text-sm font-semibold text-stone-700 mb-1">Product Name</label>
      <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}"
             class="w-full border border-stone-300 rounded-md px-4 py-2 focus:ring-amber-600 focus:border-amber-600" required>
    </div>

    {{-- SKU --}}
    <div>
      <label class="block text-sm font-semibold text-stone-700 mb-1">SKU</label>
      <input type="text" name="sku" value="{{ old('sku', $product->sku ?? '') }}"
             class="w-full border border-stone-300 rounded-md px-4 py-2 focus:ring-amber-600 focus:border-amber-600">
    </div>

    {{-- Category --}}
    <div>
      <label class="block text-sm font-semibold text-stone-700 mb-1">Category</label>
      <select name="category_id" class="w-full border border-stone-300 rounded-md px-4 py-2 focus:ring-amber-600 focus:border-amber-600">
        <option value="">— Select Category —</option>
        @foreach($categories as $cat)
          <option value="{{ $cat->id }}" @selected(old('category_id', $product->category_id ?? '') == $cat->id)>
            {{ $cat->name }}
          </option>
        @endforeach
      </select>
    </div>

    {{-- Brand --}}
    <div>
      <label class="block text-sm font-semibold text-stone-700 mb-1">Brand</label>
      <select name="brand_id" class="w-full border border-stone-300 rounded-md px-4 py-2 focus:ring-amber-600 focus:border-amber-600">
        <option value="">— Select Brand —</option>
        @foreach($brands as $brand)
          <option value="{{ $brand->id }}" @selected(old('brand_id', $product->brand_id ?? '') == $brand->id)>
            {{ $brand->name }}
          </option>
        @endforeach
      </select>
    </div>

    {{-- Price --}}
    <div>
      <label class="block text-sm font-semibold text-stone-700 mb-1">Price (৳)</label>
      <input type="number" step="0.01" name="price" value="{{ old('price', $product->price ?? '') }}"
             class="w-full border border-stone-300 rounded-md px-4 py-2 focus:ring-amber-600 focus:border-amber-600" required>
    </div>

    {{-- Discount Price --}}
    <div>
      <label class="block text-sm font-semibold text-stone-700 mb-1">Discount Price (৳)</label>
      <input type="number" step="0.01" name="discount_price" value="{{ old('discount_price', $product->discount_price ?? '') }}"
             class="w-full border border-stone-300 rounded-md px-4 py-2 focus:ring-amber-600 focus:border-amber-600">
    </div>

    {{-- Stock --}}
    <div>
      <label class="block text-sm font-semibold text-stone-700 mb-1">Stock Quantity</label>
      <input type="number" name="stock_qty" value="{{ old('stock_qty', $product->stock_qty ?? 0) }}"
             class="w-full border border-stone-300 rounded-md px-4 py-2 focus:ring-amber-600 focus:border-amber-600" min="0">
    </div>

    {{-- Active --}}
    <div class="flex items-center space-x-2 mt-6">
      <input type="checkbox" name="is_active" id="activeCheck"
             class="w-4 h-4 accent-amber-600 border-stone-300 rounded"
             {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
      <label for="activeCheck" class="text-sm text-stone-700 font-medium">Active</label>
    </div>
  </div>

  {{-- Descriptions --}}
  <div class="mt-8 space-y-6">
    <div>
      <label class="block text-sm font-semibold text-stone-700 mb-1">Short Description</label>
      <textarea name="short_description" rows="2"
                class="w-full border border-stone-300 rounded-md px-4 py-2 focus:ring-amber-600 focus:border-amber-600">{{ old('short_description', $product->short_description ?? '') }}</textarea>
    </div>

    <div>
      <label class="block text-sm font-semibold text-stone-700 mb-1">Full Description</label>
      <textarea name="description" rows="4"
                class="w-full border border-stone-300 rounded-md px-4 py-2 focus:ring-amber-600 focus:border-amber-600">{{ old('description', $product->description ?? '') }}</textarea>
    </div>
  </div>

  {{-- Images --}}
  <div class="mt-8">
    <label class="block text-sm font-semibold text-stone-700 mb-1">Product Images</label>
    <input type="file" name="images[]" multiple accept="image/*"
           class="w-full border border-stone-300 rounded-md px-4 py-2 focus:ring-amber-600 focus:border-amber-600">

    @if(!empty($product->images))
      <div class="flex flex-wrap gap-3 mt-4">
        @foreach($product->images as $img)
          <img src="{{ asset('storage/'.$img->image_url) }}" alt=""
               class="w-20 h-20 rounded-md object-cover border border-stone-200 shadow-sm">
        @endforeach
      </div>
    @endif
  </div>

  {{-- Buttons --}}
  <div class="flex justify-end gap-3 mt-10">
    <a href="{{ route('admin.products.index') }}"
       class="bg-stone-200 hover:bg-stone-300 text-stone-800 font-medium px-6 py-2 rounded-md transition">Cancel</a>
    <button type="submit"
            class="bg-amber-600 hover:bg-amber-700 text-white font-medium px-6 py-2 rounded-md shadow transition">
      {{ $submitLabel ?? 'Save Product' }}
    </button>
  </div>
</div>
