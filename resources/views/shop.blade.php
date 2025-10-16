@extends('layouts.app')

@section('title', 'Shop — Deshio')

@section('content')
<section class="bg-stone-50 py-14">
  <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-10">

    {{-- ================================
         SIDEBAR
    ================================== --}}
    <aside class="bg-white border border-stone-200 rounded-xl shadow-sm p-6 md:sticky md:top-24 h-fit">
      <h3 class="text-lg font-semibold text-stone-800 mb-4">Shop by Category</h3>
      <ul class="space-y-2">
        @foreach($categories as $cat)
          <li>
            <a href="{{ route('shop.index', ['category' => $cat->slug]) }}"
               class="block px-3 py-2 rounded-md text-sm font-medium
                      {{ $categorySlug === $cat->slug ? 'bg-amber-100 text-amber-800' : 'text-stone-700 hover:bg-stone-100 hover:text-amber-700' }}">
              {{ $cat->name }}
            </a>

            {{-- Subcategories --}}
            @if($cat->children->isNotEmpty())
              <ul class="ml-4 mt-2 space-y-1 border-l border-stone-200 pl-3">
                @foreach($cat->children as $sub)
                  <li>
                    <a href="{{ route('shop.index', ['category' => $sub->slug]) }}"
                       class="block text-xs px-2 py-1 rounded-md
                              {{ $categorySlug === $sub->slug ? 'bg-amber-50 text-amber-700 font-semibold' : 'text-stone-600 hover:bg-stone-100 hover:text-amber-700' }}">
                      {{ $sub->name }}
                    </a>
                  </li>
                @endforeach
              </ul>
            @endif
          </li>
        @endforeach
      </ul>
    </aside>

    {{-- ================================
         PRODUCT GRID
    ================================== --}}
    <div class="col-span-3">
      <div class="flex justify-between items-center mb-8">
        <h2 class="text-2xl font-bold text-stone-800">
          {{ $categorySlug ? ucwords(str_replace('-', ' ', $categorySlug)) : 'All Products' }}
        </h2>
        <span class="text-sm text-stone-500">{{ $products->total() }} items</span>
      </div>

      @if($products->count())
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
          @foreach($products as $p)
            <x-product-card :product="$p" />
          @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-10">
          {{ $products->links('pagination::tailwind') }}
        </div>
      @else
        <div class="bg-white border border-stone-200 rounded-xl shadow-sm p-10 text-center text-stone-500">
          No products found for this category.
        </div>
      @endif
    </div>

  </div>
</section>
@endsection
