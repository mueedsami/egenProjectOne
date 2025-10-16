@extends('layouts.app')

@section('title', 'All Categories — Deshio')

@section('content')
<section class="bg-stone-50 py-16">
  <div class="max-w-7xl mx-auto px-6">

    {{-- Page Header --}}
    <div class="text-center mb-12">
      <h1 class="text-4xl font-bold text-stone-900">All Categories</h1>
      <p class="text-stone-500 mt-2">Browse our collections and discover subcategories</p>
    </div>

    {{-- Category Blocks --}}
    <div class="space-y-16">
      @foreach($categories as $cat)
        <div>
          {{-- Parent Category --}}
          <div class="mb-6 text-center">
            <a href="{{ route('category.show', $cat->slug) }}"
               class="inline-block group">
              <div class="relative overflow-hidden rounded-xl shadow-sm w-full max-w-3xl mx-auto">
                <!-- <img src="{{ asset($cat->image ?? 'images/no-image.png') }}" -->
                <img src="{{ asset('images/'.(is_array($cat) ? $cat['image'] : $cat->image ?? 'no-image.jpg')) }}"
                     alt="{{ $cat->name }}"
                     class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-700">
                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition"></div>
                <h2 class="absolute inset-0 flex items-center justify-center text-3xl md:text-4xl font-bold text-white tracking-wide">
                  {{ strtoupper($cat->name) }}
                </h2>
              </div>
            </a>
          </div>

          {{-- Subcategories --}}
          @if($cat->children->isNotEmpty())
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
              @foreach($cat->children as $sub)
                <a href="{{ route('category.show', $sub->slug) }}"
                   class="group relative overflow-hidden rounded-xl shadow-sm hover:shadow-md transition-all duration-300">
                  <img src="{{ asset($sub->image ?? 'images/no-image.png') }}"
                       alt="{{ $sub->name }}"
                       class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                  <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition"></div>
                  <span class="absolute bottom-4 left-1/2 -translate-x-1/2 text-white font-medium text-sm uppercase tracking-wide">
                    {{ $sub->name }}
                  </span>
                </a>
              @endforeach
            </div>
          @else
            <p class="text-center text-stone-400 italic">No subcategories yet.</p>
          @endif
        </div>
      @endforeach
    </div>
  </div>
</section>
@endsection
