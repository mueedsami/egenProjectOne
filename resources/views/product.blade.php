@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        {{-- Product Image --}}
        <div class="col-md-6 text-center">
            <img src="{{ $product->image_url ? asset('storage/' . $product->image_url) : asset('template/images/product_1.png') }}"
                 alt="{{ $product->name }}" class="img-fluid rounded shadow">
        </div>

        {{-- Product Details --}}
        <div class="col-md-6">
            <h2>{{ $product->name }}</h2>
            <p class="text-muted">SKU: {{ $product->sku ?? 'N/A' }}</p>

            {{-- Price Section --}}
            <div class="mb-3">
                <h4 style="color: #fe4c50;">
                    {{ number_format($product->price, 2) }} ₺
                    @if($product->discount_price)
                        <span style="text-decoration:line-through; color:gray;">
                            {{ number_format($product->discount_price, 2) }} ₺
                        </span>
                    @endif
                </h4>
            </div>

            {{-- Description --}}
            <p>{{ $product->description }}</p>

            {{-- Add to Cart --}}
            <div class="mt-4">
                <form action="{{route ('cart.add', $product->id)}}" method="POST">
                    @csrf
                    <div class="form-group d-flex align-items-center">
                        <input type="number" name="quantity" value="1" min="1" class="form-control w-25 me-3">
                        <button type="submit" class="btn btn-danger px-4">Sepete Ekle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Related Products --}}
    <div class="row mt-5">
        <div class="col text-center">
            <h3 class="mb-4">Benzer Ürünler</h3>
        </div>
    </div>
    <div class="row">
        @php
            $related = \App\Models\Product::where('id', '!=', $product->id)->take(4)->get();
        @endphp

        @foreach($related as $item)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="{{ $item->image_url ? asset('storage/' . $item->image_url) : asset('template/images/product_2.png') }}" class="card-img-top" alt="{{ $item->name }}">
                    <div class="card-body text-center">
                        <h6>{{ $item->name }}</h6>
                        <p class="text-danger mb-0">{{ number_format($item->price, 2) }} ₺</p>
                        <a href="{{ route('product.show', $item->slug) }}" class="btn btn-outline-dark btn-sm mt-2">İncele</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
