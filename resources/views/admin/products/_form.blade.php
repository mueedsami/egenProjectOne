@csrf
<div class="card shadow-sm p-4">
    <div class="row g-3">
        {{-- Name --}}
        <div class="col-md-6">
            <label class="form-label">Product Name</label>
            <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" class="form-control" required>
        </div>

        {{-- SKU --}}
        <div class="col-md-6">
            <label class="form-label">SKU</label>
            <input type="text" name="sku" value="{{ old('sku', $product->sku ?? '') }}" class="form-control">
        </div>

        {{-- Category --}}
        <div class="col-md-6">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-select">
                <option value="">— Select Category —</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(old('category_id', $product->category_id ?? '') == $cat->id)>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Brand --}}
        <div class="col-md-6">
            <label class="form-label">Brand</label>
            <select name="brand_id" class="form-select">
                <option value="">— Select Brand —</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" @selected(old('brand_id', $product->brand_id ?? '') == $brand->id)>
                        {{ $brand->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Price / Discount --}}
        <div class="col-md-6">
            <label class="form-label">Price (₺)</label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $product->price ?? '') }}" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Discount Price (₺)</label>
            <input type="number" step="0.01" name="discount_price" value="{{ old('discount_price', $product->discount_price ?? '') }}" class="form-control">
        </div>

        {{-- Stock --}}
        <div class="col-md-6">
            <label class="form-label">Stock Quantity</label>
            <input type="number" name="stock_qty" value="{{ old('stock_qty', $product->stock_qty ?? 0) }}" class="form-control" min="0">
        </div>

        {{-- Active --}}
        <div class="col-md-6 d-flex align-items-center">
            <div class="form-check mt-4">
                <input type="checkbox" name="is_active" id="activeCheck" class="form-check-input"
                    {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
                <label for="activeCheck" class="form-check-label">Active</label>
            </div>
        </div>

        {{-- Descriptions --}}
        <div class="col-12">
            <label class="form-label">Short Description</label>
            <textarea name="short_description" class="form-control" rows="2">{{ old('short_description', $product->short_description ?? '') }}</textarea>
        </div>
        <div class="col-12">
            <label class="form-label">Full Description</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description ?? '') }}</textarea>
        </div>

        {{-- Images --}}
        <div class="col-12">
            <label class="form-label">Product Images</label>
            <input type="file" name="images[]" class="form-control" multiple accept="image/*">

            @if(!empty($product->images))
                <div class="d-flex flex-wrap gap-2 mt-2">
                    @foreach($product->images as $img)
                        <img src="{{ asset('storage/'.$img->image_url) }}" alt="" style="width:80px;height:80px;object-fit:cover;border-radius:6px;">
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Buttons --}}
        <div class="col-12 text-end mt-3">
            <button class="btn btn-success">{{ $submitLabel ?? 'Save' }}</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </div>
</div>
