@props(['product'])

@php
    $img = optional($product->images->first())->image_url
        ? asset('storage/'.$product->images->first()->image_url)
        : asset('images/no-image.png');

    $price = floatval($product->price);
    $discountPrice = floatval($product->discount_price);
    $discount = ($price > 0 && $discountPrice > 0 && $discountPrice < $price)
        ? round((($price - $discountPrice) / $price) * 100)
        : 0;

    $isSoldOut = isset($product->stock_qty) && $product->stock_qty <= 0;
@endphp

<div class="group relative bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition duration-300 border border-stone-100">
    {{-- Product Image --}}
    <div class="relative">
        <a href="{{ route('product.show', $product->slug) }}">
            <img src="{{ $img }}" alt="{{ $product->name }}"
                class="w-full h-72 object-cover group-hover:scale-105 transition-transform duration-700 ease-in-out">
        </a>

        {{-- Discount Badge --}}
        @if($discount > 0)
            <span class="absolute top-3 right-3 bg-amber-600 text-white text-xs font-semibold px-2.5 py-1.5 rounded-full shadow">
                -{{ $discount }}%
            </span>
        @endif

        {{-- Sold Out Badge --}}
        @if($isSoldOut)
            <span class="absolute top-6 right-3 bg-stone-800/90 text-white text-[11px] font-semibold px-2.5 py-1.5 rounded-full shadow">
                SOLD OUT
            </span>
        @endif
    </div>

    {{-- Product Info --}}
    <div class="p-4 text-center">
        <h4 class="text-stone-800 font-medium text-sm truncate mb-1">
            {{ $product->name }}
        </h4>

        @if($product->category)
            <p class="text-xs text-stone-500 mb-2">
                {{ $product->category->name }}
            </p>
        @endif

        {{-- Price --}}
        <p class="font-semibold text-base text-amber-700 mb-3">
            ৳{{ number_format($product->discount_price ?? $product->price, 2) }}
            @if($product->discount_price)
                <span class="text-stone-400 line-through text-xs ml-1">
                    ৳{{ number_format($product->price, 2) }}
                </span>
            @endif
        </p>

        {{-- Add to Cart --}}
        <form action="{{ route('cart.add', $product->id) }}" method="POST">
            @csrf
            <button type="submit"
                class="bg-amber-600 hover:bg-amber-700 text-white text-xs font-semibold uppercase px-4 py-2 rounded-md transition w-full">
                Add to Cart
            </button>
        </form>
    </div>
</div>
