@extends('layouts.app')

@section('title', 'Admin · Products')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Products</h3>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ Add Product</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form class="mb-3" method="GET">
        <div class="input-group">
            <input type="text" name="q" class="form-control" value="{{ $q }}" placeholder="Search name or SKU...">
            <button class="btn btn-outline-secondary">Search</button>
        </div>
    </form>

    <div class="table-responsive bg-white shadow-sm rounded">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th style="width:60px;">Image</th>
                    <th>Name</th>
                    <th>SKU</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th class="text-end">Price</th>
                    <th class="text-center">Stock</th>
                    <th class="text-center">Active</th>
                    <th class="text-end" style="width:160px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $p)
                    <tr>
                        <td>
                            <img src="{{ $p->primary_image_url }}" alt="" style="width:48px;height:48px;object-fit:cover;border-radius:6px;">
                        </td>
                        <td>{{ $p->name }}</td>
                        <td>{{ $p->sku }}</td>
                        <td>{{ optional($p->category)->name }}</td>
                        <td>{{ optional($p->brand)->name }}</td>
                        <td class="text-end">{{ number_format($p->price,2) }} ₺</td>
                        <td class="text-center">{{ $p->stock_qty }}</td>
                        <td class="text-center">
                            @if($p->is_active)
                                <span class="badge bg-success">Yes</span>
                            @else
                                <span class="badge bg-secondary">No</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.products.edit', $p) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('admin.products.destroy', $p) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this product?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center py-4">No products yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $products->links() }}
    </div>
</div>
@endsection
