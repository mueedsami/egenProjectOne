@extends('layouts.app')

@section('title', 'Admin · Products')

@section('content')
<div class="container py-5">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-semibold">Products</h3>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ Add Product</a>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Search Bar --}}
    <form class="mb-3" method="GET" action="{{ route('admin.products.index') }}">
        <div class="input-group">
            <input type="text" name="q" class="form-control" value="{{ $q }}" placeholder="Search name or SKU...">
            <button class="btn btn-outline-secondary" type="submit">Search</button>
        </div>
    </form>

    {{-- Product Table --}}
    <div class="table-responsive bg-white shadow-sm rounded">
        <table class="table mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th style="width:60px;">Image</th>
                    <th>Name</th>
                    <th>SKU</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th class="text-end">Price</th>
                    <th class="text-center">Stock</th>
                    <th class="text-center">Active</th>
                    <th class="text-center">Created</th>
                    <th class="text-end" style="width:180px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $p)
                    <tr>
                        {{-- Thumbnail --}}
                        <td>
                            <img src="{{ $p->primary_image_url ?? asset('template/images/default.png') }}"
                                 alt="product image"
                                 style="width:48px;height:48px;object-fit:cover;border-radius:6px;">
                        </td>

                        {{-- Basic Info --}}
                        <td>
                            <strong>{{ $p->name }}</strong>
                            <div class="text-muted small">
                                {{ Str::limit($p->short_description, 40) }}
                            </div>
                        </td>
                        <td>{{ $p->sku ?? '-' }}</td>
                        <td>{{ optional($p->category)->name ?? '-' }}</td>
                        <td>{{ optional($p->brand)->name ?? '-' }}</td>

                        {{-- Price --}}
                        <td class="text-end">
                            {{ number_format($p->price, 2) }} ₺
                            @if($p->discount_price)
                                <div class="text-muted small">
                                    <del>{{ number_format($p->discount_price, 2) }} ₺</del>
                                </div>
                            @endif
                        </td>

                        {{-- Stock --}}
                        <td class="text-center">
                            @if($p->stock_qty > 0)
                                <span class="badge bg-success">{{ $p->stock_qty }}</span>
                            @else
                                <span class="badge bg-danger">Out</span>
                            @endif
                        </td>

                        {{-- Active Status --}}
                        <td class="text-center">
                            @if($p->is_active)
                                <span class="badge bg-success">Yes</span>
                            @else
                                <span class="badge bg-secondary">No</span>
                            @endif
                        </td>

                        {{-- Created At --}}
                        <td class="text-center text-muted">
                            {{ $p->created_at ? $p->created_at->diffForHumans() : '-' }}
                        </td>

                        {{-- Actions --}}
                        <td class="text-end">
                            <a href="{{ route('admin.products.edit', $p) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="fa fa-pencil"></i> Edit
                            </a>
                            <form action="{{ route('admin.products.destroy', $p) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this product?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="fa fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center py-4 text-muted">
                            No products found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-3 d-flex justify-content-end">
        {{ $products->links() }}
    </div>
</div>
@endsection
