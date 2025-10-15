@extends('layouts.app')

@section('title', $product->name . ' — Deshio')

@section('content')
<section class="bg-stone-50 py-20">
  <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-12">
    
    {{-- ====================== PRODUCT IMAGE GALLERY ====================== --}}
    <div>
      @php
          $images = $product->images ?? collect(); // Use relation if available
      @endphp

      @if($images->isNotEmpty())
        {{-- Swiper gallery --}}
        <div class="swiper mainGallery rounded-2xl shadow-lg overflow-hidden">
          <div class="swiper-wrapper">
            @foreach($images as $img)
              <div class="swiper-slide">
                <img src="{{ asset($img->image_url) }}"
                     alt="{{ $product->name }}" class="w-full object-cover rounded-2xl">
              </div>
            @endforeach
          </div>
        </div>

        {{-- Thumbnail nav --}}
        <div class="swiper thumbGallery mt-4">
          <div class="swiper-wrapper">
            @foreach($images as $img)
              <div class="swiper-slide cursor-pointer">
                <img src="{{ asset($img->image_url) }}"
                     class="w-24 h-24 object-cover rounded-md border border-stone-200 hover:border-amber-500 transition">
              </div>
            @endforeach
          </div>
        </div>
      @else
        {{-- Fallback if no images --}}
        <img src="{{ asset('template/images/no-image.png') }}" class="w-full rounded-2xl shadow-lg" alt="{{ $product->name }}">
      @endif
    </div>

    {{-- ====================== PRODUCT DETAILS ====================== --}}
    <div class="flex flex-col justify-center">
      <h1 class="text-3xl font-semibold text-stone-900 mb-2">{{ $product->name }}</h1>
      <p class="text-stone-500 text-sm mb-6">SKU: {{ $product->sku ?? 'N/A' }}</p>

      {{-- Price --}}
      <div class="mb-6">
        <span class="text-3xl font-semibold text-amber-700">
          ৳{{ number_format($product->discount_price ?? $product->price, 0) }}
        </span>
        @if($product->discount_price)
          <span class="text-stone-400 line-through ml-2 text-lg">
            ৳{{ number_format($product->price, 0) }}
          </span>
        @endif
      </div>

      {{-- Description --}}
      <div class="prose max-w-none text-stone-700 leading-relaxed mb-8">
        {!! nl2br(e($product->description ?? 'No description available.')) !!}
      </div>

      {{-- Add to Cart --}}
      <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex items-center gap-4">
        @csrf
        <input type="number" name="quantity" value="1" min="1"
               class="border border-stone-300 rounded-md px-3 py-2 w-20 focus:ring-2 focus:ring-amber-500 focus:outline-none">
        <button type="submit"
                class="bg-amber-600 hover:bg-amber-700 text-white px-8 py-2.5 rounded-md font-medium shadow-md transition">
          Add to Cart
        </button>
      </form>
    </div>
  </div>
</section>

{{-- ====================== RELATED PRODUCTS ====================== --}}
<section class="py-20 bg-white border-t border-stone-200">
  <div class="max-w-7xl mx-auto px-6 text-center">
    <h3 class="text-2xl font-semibold text-stone-800 mb-10">You May Also Like</h3>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-8">
      @php
          $related = \App\Models\Product::where('category_id', $product->category_id)
              ->where('id', '!=', $product->id)
              ->take(4)->get();
      @endphp

      @foreach($related as $item)
        @php
            $relImage = optional($item->images->first())->image_url ?? 'template/images/no-image.png';
        @endphp
        <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition duration-300">
          <a href="{{ route('product.show', $item->slug) }}" class="block relative group">
            <img src="{{ asset($relImage) }}" alt="{{ $item->name }}"
                 class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-500">
            @if($item->discount_price)
              @php $off = round(100 - ($item->discount_price / $item->price * 100)); @endphp
              <span class="absolute top-3 left-3 bg-amber-600 text-white text-xs px-2 py-1 rounded-md">-{{ $off }}%</span>
            @endif
          </a>
          <div class="p-5 text-center">
            <h4 class="font-medium text-stone-800 text-sm truncate mb-1">{{ $item->name }}</h4>
            <p class="text-amber-700 font-semibold text-base">
              ৳{{ number_format($item->discount_price ?? $item->price, 0) }}
              @if($item->discount_price)
                <span class="line-through text-stone-400 text-xs ml-1">
                  ৳{{ number_format($item->price, 0) }}
                </span>
              @endif
            </p>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

@push('scripts')
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const mainGallery = new Swiper(".mainGallery", {
      spaceBetween: 10,
      loop: true,
      thumbs: { swiper: null },
    });

    const thumbGallery = new Swiper(".thumbGallery", {
      spaceBetween: 10,
      slidesPerView: 4,
      freeMode: true,
      watchSlidesProgress: true,
    });

    mainGallery.params.thumbs.swiper = thumbGallery;
    mainGallery.update();
  });
</script>
@endpush
@endsection
