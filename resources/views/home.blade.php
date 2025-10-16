@extends('layouts.app')

@section('title', 'Deshio — Contemporary Bangladeshi Fashion')

@section('content')

{{-- ===============================================================
   HERO SECTION
================================================================ --}}
<section class="relative overflow-hidden bg-stone-50">
  <div class="swiper heroSwiper">
    <div class="swiper-wrapper">
      @foreach($heroBanners as $b)
        <div class="swiper-slide relative">
          <img src="{{ asset('images/'.$b['image']) }}" alt="{{ $b['title'] }}"
               class="w-full h-[600px] object-cover">
          <div class="absolute inset-0 bg-black/50"></div>
          <div class="absolute inset-0 flex flex-col items-center justify-center text-center text-white">
            <h2 class="text-4xl md:text-6xl font-bold mb-4 tracking-tight text-white">{{ $b['title'] }}</h2>
            <p class="text-lg md:text-xl mb-8 opacity-90 text-white">{{ $b['subtitle'] }}</p>
            <a href="{{ $b['link'] }}"
               class="px-8 py-3 bg-amber-600 hover:bg-amber-700 rounded-md shadow-lg transition font-medium text-white">
              Shop Now
            </a>
          </div>
        </div>
      @endforeach
    </div>
    <div class="swiper-button-next !text-white"></div>
    <div class="swiper-button-prev !text-white"></div>
  </div>
</section>


{{-- ===============================================================
   CATEGORY SHOWCASE
================================================================ --}}
<section class="py-20 bg-white">
  <div class="max-w-7xl mx-auto px-6">
    <div class="text-center mb-12">
      <h3 class="text-3xl md:text-4xl font-semibold text-stone-800">Shop by Category</h3>
      <p class="text-stone-500 mt-2">Explore our most loved collections</p>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
      @foreach($categories as $c)
        <a href="/category/{{ is_array($c) ? $c['slug'] : $c->slug }}"
           class="group relative overflow-hidden rounded-xl shadow-sm hover:shadow-lg transition-all duration-300">
          <img src="{{ asset('images/'.(is_array($c) ? $c['image'] : $c->image ?? 'no-image.png')) }}"
               alt="{{ is_array($c) ? $c['name'] : $c->name }}"
               class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
          <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition"></div>
          <span class="absolute bottom-4 left-1/2 -translate-x-1/2 text-white font-medium text-sm uppercase tracking-wide">
            {{ is_array($c) ? $c['name'] : $c->name }}
          </span>
        </a>
      @endforeach
    </div>
  </div>
</section>


{{-- ===============================================================
   FEATURED / NEW ARRIVALS
================================================================ --}}
<section class="py-14 bg-stone-50 border-t border-stone-200">
  <div class="max-w-7xl mx-auto px-6">
    <div class="flex items-center justify-between mb-10">
      <h3 class="text-3xl font-semibold text-stone-800">New Arrivals</h3>
      <div class="flex items-center space-x-2">
        <button class="featured-prev bg-white border border-stone-200 p-2 rounded-full hover:bg-amber-50">
          <i class="fa fa-chevron-left text-stone-600"></i>
        </button>
        <button class="featured-next bg-white border border-stone-200 p-2 rounded-full hover:bg-amber-50">
          <i class="fa fa-chevron-right text-stone-600"></i>
        </button>
      </div>
    </div>

    <div class="swiper featuredSwiper">
      <div class="swiper-wrapper">
        @foreach($products as $p)
          <div class="swiper-slide w-[250px] mr-5">
            <x-product-card :product="$p" />
          </div>
        @endforeach
      </div>
    </div>
  </div>
</section>


{{-- ===============================================================
   CATEGORY DISCOVERY BY SUBCATEGORY
================================================================ --}}
@foreach($categories as $cat)
  @if(isset($cat->children) && $cat->children->isNotEmpty())
  <section class="py-7 bg-white border-t border-stone-100">
    <div class="max-w-7xl mx-auto px-6">

      {{-- Section Header --}}
      <div class="flex justify-between items-center mb-8">
        <h3 class="text-2xl font-bold text-stone-900 uppercase tracking-wide">{{ $cat->name }}</h3>
        <a href="{{ route('category.show', $cat->slug) }}" class="text-amber-700 hover:underline text-sm font-medium">
          View All
        </a>
      </div>

      {{-- Subcategory Tabs --}}
      <div class="flex flex-wrap gap-4 mb-6 border-b border-stone-200 pb-2">
        @foreach($cat->children as $i => $sub)
          <button 
            class="subcategory-tab px-3 py-1 rounded-md text-sm font-semibold transition 
                   {{ $i==0 ? 'text-amber-700 border-b-2 border-amber-600' : 'text-stone-600 hover:text-amber-700' }}"
            data-target="#subcat-{{ $sub->id }}">
            {{ strtoupper($sub->name) }}
          </button>
        @endforeach
      </div>

      {{-- Subcategory Carousels --}}
      @foreach($cat->children as $i => $sub)
      <div id="subcat-{{ $sub->id }}" class="subcategory-carousel {{ $i>0 ? 'hidden' : '' }}">
        @if($sub->products->count())
          <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @foreach($sub->products as $p)
              <x-product-card :product="$p" />
            @endforeach
          </div>
        @else
          <div class="text-center py-10 text-stone-400 italic text-sm">
            No products available in this category yet.
          </div>
        @endif
      </div>
      @endforeach

    </div>
  </section>
  @endif
@endforeach




{{-- ===============================================================
   PROMO BANNERS
================================================================ --}}
<section class="py-20 bg-white">
  <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-8 px-6">
    @foreach($promoBanners as $p)
      <a href="{{ $p['link'] }}" class="relative overflow-hidden rounded-2xl shadow-md group">
        <img src="{{ asset('images/'.$p['image']) }}" class="w-full h-72 object-cover group-hover:scale-105 transition-transform duration-700">
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
        <div class="absolute bottom-6 left-6 text-white">
          <h4 class="text-2xl font-semibold">{{ $p['title'] }}</h4>
          <p class="text-sm text-stone-200">{{ $p['subtitle'] }}</p>
        </div>
      </a>
    @endforeach
  </div>
</section>


{{-- ===============================================================
   BENEFITS
================================================================ --}}
<section class="bg-stone-100 py-14">
  <div class="max-w-6xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-10 text-center">
    <div>
      <i class="fa fa-truck text-amber-700 text-3xl mb-2"></i>
      <p class="font-medium text-stone-700">Free Delivery</p>
      <p class="text-sm text-stone-500">On orders above ৳1000</p>
    </div>
    <div>
      <i class="fa fa-sync text-amber-700 text-3xl mb-2"></i>
      <p class="font-medium text-stone-700">Easy Returns</p>
      <p class="text-sm text-stone-500">Within 7 days</p>
    </div>
    <div>
      <i class="fa fa-lock text-amber-700 text-3xl mb-2"></i>
      <p class="font-medium text-stone-700">Secure Payments</p>
      <p class="text-sm text-stone-500">SSL Protected</p>
    </div>
    <div>
      <i class="fa fa-headphones text-amber-700 text-3xl mb-2"></i>
      <p class="font-medium text-stone-700">24/7 Support</p>
      <p class="text-sm text-stone-500">We’re here to help</p>
    </div>
  </div>
</section>


{{-- ===============================================================
   NEWSLETTER CTA
================================================================ --}}
<section class="bg-amber-700 text-white py-20 text-center">
  <div class="max-w-2xl mx-auto px-6">
    <h3 class="text-4xl font-semibold mb-4">Join the Deshio Circle</h3>
    <p class="text-amber-100 mb-6">Be first to hear about exclusive offers and seasonal drops.</p>
    <form class="flex max-w-md mx-auto">
      <input type="email"
             placeholder="Enter your email"
             class="flex-1 px-4 py-3 text-stone-800 rounded-l-md focus:outline-none"
             required>
      <button type="submit"
              class="px-6 bg-stone-900 hover:bg-stone-800 rounded-r-md font-medium">
        Subscribe
      </button>
    </form>
  </div>
</section>

@endsection


@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {

  // =========================
  // HERO SWIPER
  // =========================
  new Swiper(".heroSwiper", {
    slidesPerView: 1,
    loop: true,
    navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
    autoplay: { delay: 5000, disableOnInteraction: false },
    effect: 'fade',
    speed: 1000,
  });

  // =========================
  // FEATURED / NEW ARRIVALS SWIPER
  // =========================
  const featuredSwiper = new Swiper(".featuredSwiper", {
    slidesPerView: 4,
    spaceBetween: 24,
    loop: true,
    grabCursor: true,
    navigation: {
      nextEl: ".featured-next",
      prevEl: ".featured-prev"
    },
    autoplay: {
      delay: 4000,
      disableOnInteraction: false,
      pauseOnMouseEnter: true
    },
    breakpoints: {
      320:  { slidesPerView: 1.2, spaceBetween: 14 },
      640:  { slidesPerView: 2,   spaceBetween: 18 },
      1024: { slidesPerView: 3,   spaceBetween: 20 },
      1280: { slidesPerView: 4,   spaceBetween: 24 }
    }
  });

  // =========================
  // SUBCATEGORY TAB SWITCHER
  // =========================
  document.querySelectorAll('.subcategory-tab').forEach(tab => {
    tab.addEventListener('click', function() {
      const target = this.getAttribute('data-target');
      const wrapper = this.closest('section');

      // Reset all tabs
      wrapper.querySelectorAll('.subcategory-tab').forEach(btn => {
        btn.classList.remove('text-amber-700', 'border-b-2', 'border-amber-600');
        btn.classList.add('text-stone-600');
      });

      // Activate clicked tab
      this.classList.add('text-amber-700', 'border-b-2', 'border-amber-600');
      this.classList.remove('text-stone-600');

      // Show matching product grid
      wrapper.querySelectorAll('.subcategory-carousel').forEach(c => c.classList.add('hidden'));
      wrapper.querySelector(target).classList.remove('hidden');
    });
  });

});
</script>
@endpush
