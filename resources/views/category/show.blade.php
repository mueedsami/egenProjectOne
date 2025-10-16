@extends('layouts.app')

@section('title', $category->name . ' — Deshio')

@section('content')
<section class="bg-stone-50 py-16">
  <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-10">

    {{-- ====================== SIDEBAR ====================== --}}
    <aside class="bg-white border border-stone-200 rounded-xl shadow-sm h-fit p-6">
      <h4 class="text-lg font-semibold text-stone-900 mb-4">Filter by Subcategory</h4>
      <ul class="space-y-2">
        <li>
          <a href="{{ route('category.show', $category->slug) }}"
             class="block px-3 py-2 rounded-md text-sm font-medium transition
                    {{ !$selectedSubcategory ? 'bg-amber-600 text-white' : 'text-stone-700 hover:bg-stone-100' }}">
            All {{ $category->name }}
          </a>
        </li>

        @foreach($category->children as $child)
          <li>
            <a href="{{ route('category.show', ['slug' => $category->slug, 'sub' => $child->slug]) }}"
               class="block px-3 py-2 rounded-md text-sm font-medium transition
                      {{ $selectedSubcategory && $selectedSubcategory->id == $child->id
                          ? 'bg-amber-600 text-white'
                          : 'text-stone-700 hover:bg-stone-100' }}">
              {{ $child->name }}
            </a>
          </li>
        @endforeach
      </ul>
    </aside>

    {{-- ====================== MAIN CONTENT ====================== --}}
    <main class="md:col-span-3">
      <div class="flex items-center justify-between mb-8">
        <div>
          <h2 class="text-3xl font-semibold text-stone-900">
            {{ $selectedSubcategory ? $selectedSubcategory->name : $category->name }}
          </h2>
          <p class="text-stone-500 text-sm mt-1">
            {{ $products->total() }} product{{ $products->total() !== 1 ? 's' : '' }} found
          </p>
        </div>
        <a href="{{ url('/') }}" class="text-amber-600 hover:text-amber-700 text-sm font-medium">
          ← Back to Home
        </a>
      </div>

      {{-- Product Grid --}}
      <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
        @forelse($products as $p)
          <div class="group bg-white border border-stone-200 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
            <a href="{{ route('product.show', $p->slug) }}">
              <img src="{{ $p->image_url ? asset('storage/'.$p->image_url) : asset('images/no-image.png') }}"
                   alt="{{ $p->name }}"
                   class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-500">
            </a>
            <div class="p-4 text-center">
              <h3 class="text-stone-800 font-medium text-sm truncate">{{ $p->name }}</h3>
              <div class="mt-2">
                <span class="text-amber-600 font-semibold text-base">
                  ৳{{ number_format($p->price, 2) }}
                </span>
                @if($p->discount_price)
                  <span class="text-stone-400 line-through text-sm ml-2">
                    ৳{{ number_format($p->discount_price, 2) }}
                  </span>
                @endif
              </div>
              <form action="{{ route('cart.add', $p->id) }}" method="POST" class="mt-3">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <button type="submit"
                        class="w-full bg-amber-600 hover:bg-amber-700 text-white text-sm font-medium py-2 rounded-md transition">
                  Add to Cart
                </button>
              </form>
            </div>
          </div>
        @empty
          <div class="col-span-full text-center py-20 text-stone-500">
            No products found in this category.
          </div>
        @endforelse
      </div>

      {{-- Pagination --}}
      <div class="mt-10">
        {{ $products->links('pagination::tailwind') }}
      </div>
    </main>
  </div>
</section>
@endsection
