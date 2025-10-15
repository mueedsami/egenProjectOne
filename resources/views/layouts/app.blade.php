<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>@yield('title', 'Deshio — Modern Bangladeshi Fashion')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  {{-- ===============================================================
       FONTS & ICONS
  =============================================================== --}}
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  {{-- ===============================================================
       TAILWIND / CORE STYLES
  =============================================================== --}}
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            amber: { DEFAULT: '#d97706', 50: '#fff8e1', 600: '#d97706', 700: '#b45309' },
            stone: { 50: '#fafaf9', 100: '#f5f5f4', 200: '#e7e5e4', 300: '#d6d3d1', 400: '#a8a29e', 500: '#78716c', 600: '#57534e', 700: '#44403c', 800: '#292524', 900: '#1c1917' }
          },
          fontFamily: { sans: ['Poppins', 'sans-serif'] },
        },
      },
    };
  </script>

  {{-- ===============================================================
       SWIPER (Slider)
  =============================================================== --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

  {{-- ===============================================================
       LEGACY SUPPORT (Optional)
  =============================================================== --}}
  <link rel="stylesheet" href="{{ asset('template/styles/main_styles.css') }}">
  <link rel="stylesheet" href="{{ asset('template/styles/allResponsive.css') }}">
  <link rel="stylesheet" href="{{ asset('template/styles/slider.css') }}">

  {{-- ===============================================================
       PAGE-SPECIFIC STYLES
  =============================================================== --}}
  @stack('styles')
</head>

<body class="font-sans text-stone-800 bg-white selection:bg-amber-600/20 selection:text-amber-900">

  {{-- ===============================================================
       HEADER / NAVBAR
  =============================================================== --}}
  <header class="sticky top-0 z-50 bg-white/95 backdrop-blur border-b border-stone-200 shadow-sm transition-all">
    <div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between">
      {{-- Brand --}}
      <a href="{{ url('/') }}" class="flex items-center space-x-2">
        <img src="{{ asset('images/deshio-logo.png') }}" alt="Deshio" class="h-10">
        <span class="font-semibold text-xl tracking-tight text-stone-800">Deshio</span>
      </a>

      {{-- Desktop Navigation --}}
      <nav class="hidden md:flex items-center space-x-8 text-[15px] font-medium text-stone-700">
        <a href="{{ url('/') }}" class="hover:text-amber-700 transition">Home</a>
        <a href="/shop" class="hover:text-amber-700 transition">Shop</a>
        <a href="/categories" class="hover:text-amber-700 transition">Categories</a>
        <a href="/about" class="hover:text-amber-700 transition">About</a>
        <a href="/contact" class="hover:text-amber-700 transition">Contact</a>
      </nav>

      {{-- Icons --}}
      <div class="flex items-center space-x-5">
        @auth
          <a href="{{ route('dashboard') }}" class="hover:text-amber-700 transition">
            <i class="fa-regular fa-user text-lg"></i>
          </a>
          <a href="{{ route('cart.index') }}" class="relative hover:text-amber-700 transition">
            <i class="fa-solid fa-cart-shopping text-lg"></i>
            <span class="absolute -top-2 -right-2 bg-amber-600 text-white text-xs w-4 h-4 flex items-center justify-center rounded-full">3</span>
          </a>
        @else
          <a href="{{ route('login') }}" class="text-sm font-medium hover:text-amber-700">Login</a>
          <a href="{{ route('register') }}" class="text-sm font-medium hover:text-amber-700">Register</a>
        @endauth
      </div>

      {{-- Mobile Menu Toggle --}}
      <button id="menuToggle" class="md:hidden text-stone-700 text-2xl focus:outline-none">
        <i class="fa-solid fa-bars"></i>
      </button>
    </div>

    {{-- Mobile Dropdown --}}
    <div id="mobileMenu" class="hidden md:hidden bg-white border-t border-stone-100">
      <nav class="flex flex-col px-6 py-4 space-y-3 text-stone-700 font-medium">
        <a href="/" class="hover:text-amber-700">Home</a>
        <a href="/shop" class="hover:text-amber-700">Shop</a>
        <a href="/categories" class="hover:text-amber-700">Categories</a>
        <a href="/about" class="hover:text-amber-700">About</a>
        <a href="/contact" class="hover:text-amber-700">Contact</a>
      </nav>
    </div>
  </header>

  {{-- ===============================================================
       PAGE CONTENT
  =============================================================== --}}
  <main class="min-h-screen">
    @yield('content')
  </main>

  {{-- ===============================================================
       FOOTER
  =============================================================== --}}
  <footer class="bg-stone-900 text-stone-300 mt-20 pt-16 pb-10">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-4 gap-10">
      {{-- Brand --}}
      <div>
        <img src="{{ asset('images/deshio-logo-light.png') }}" alt="Deshio" class="h-10 mb-4">
        <p class="text-sm text-stone-400 leading-relaxed">
          Deshio celebrates Bangladesh’s craftsmanship and culture through fashion — sustainable, timeless, and proudly local.
        </p>
      </div>

      {{-- Quick Links --}}
      <div>
        <h4 class="text-lg font-semibold mb-4 text-white">Quick Links</h4>
        <ul class="space-y-2 text-sm">
          <li><a href="/" class="hover:text-amber-500">Home</a></li>
          <li><a href="/shop" class="hover:text-amber-500">Shop</a></li>
          <li><a href="/about" class="hover:text-amber-500">About</a></li>
          <li><a href="/contact" class="hover:text-amber-500">Contact</a></li>
        </ul>
      </div>

      {{-- Customer Service --}}
      <div>
        <h4 class="text-lg font-semibold mb-4 text-white">Customer Care</h4>
        <ul class="space-y-2 text-sm">
          <li><a href="/returns" class="hover:text-amber-500">Returns</a></li>
          <li><a href="/shipping" class="hover:text-amber-500">Shipping Info</a></li>
          <li><a href="/faq" class="hover:text-amber-500">FAQ</a></li>
          <li><a href="/terms" class="hover:text-amber-500">Terms & Policy</a></li>
        </ul>
      </div>

      {{-- Newsletter --}}
      <div>
        <h4 class="text-lg font-semibold mb-4 text-white">Join Our Circle</h4>
        <p class="text-sm text-stone-400 mb-4">Be the first to know about new arrivals and special offers.</p>
        <form class="flex">
          <input type="email" placeholder="Your email"
                 class="flex-1 px-4 py-2 text-stone-800 rounded-l-md focus:outline-none" required>
          <button class="px-5 bg-amber-600 hover:bg-amber-700 text-white rounded-r-md font-medium">Join</button>
        </form>
      </div>
    </div>

    <div class="border-t border-stone-800 mt-12 pt-6 text-center text-stone-500 text-sm">
      © {{ date('Y') }} Deshio. All rights reserved. | Crafted with ❤️ in Bangladesh.
    </div>
  </footer>

  {{-- ===============================================================
       FLOATING CHAT BUTTON (if logged in)
  =============================================================== --}}
  @auth
    @if(Route::has('chat.index'))
      <a href="{{ route('chat.index') }}" id="chatBubble"
         class="fixed bottom-6 right-6 w-14 h-14 rounded-full bg-amber-600 flex items-center justify-center text-white shadow-lg hover:bg-amber-700 transition">
        <i class="fa fa-comments text-xl"></i>
      </a>
      <style>
        @keyframes pulse {
          0% { box-shadow: 0 0 0 0 rgba(251,191,36,0.4); }
          70% { box-shadow: 0 0 0 15px rgba(251,191,36,0); }
          100% { box-shadow: 0 0 0 0 rgba(251,191,36,0); }
        }
        #chatBubble { animation: pulse 2.5s infinite; }
      </style>
    @endif
  @endauth

  {{-- ===============================================================
       JS LIBRARIES
  =============================================================== --}}
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
  <script src="{{ asset('template/js/custom.js') }}"></script>

  {{-- Swiper --}}
  <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

  {{-- Mobile menu toggle --}}
  <script>
    const menuBtn = document.getElementById('menuToggle');
    const mobileMenu = document.getElementById('mobileMenu');
    if(menuBtn){
      menuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
      });
    }
  </script>

  {{-- Page-specific scripts --}}
  @stack('scripts')
</body>
</html>
