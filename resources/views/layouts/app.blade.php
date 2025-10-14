<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Deshio')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Core Styles -->
    <!-- CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('template/styles/main_styles.css') }}">
<link rel="stylesheet" href="{{ asset('template/styles/allResponsive.css') }}">
<link rel="stylesheet" href="{{ asset('template/styles/slider.css') }}">
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

    @stack('styles')
</head>
<body>
<div class="super_container">

    {{-- Header --}}
    @include('partials.header')

    {{-- Page Content --}}
    @yield('content')

    {{-- Footer --}}
    @include('partials.footer')

</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="{{ asset('template/js/custom.js') }}"></script>

@auth
    @if(Route::has('chat.index'))
        <!-- Floating Chat Button -->
        <a href="{{ route('chat.index') }}" 
           id="chatBubble"
           class="d-flex align-items-center justify-content-center">
            <i class="fa fa-comments"></i>
        </a>

        <style>
            #chatBubble {
                position: fixed;
                bottom: 25px;
                right: 25px;
                width: 60px;
                height: 60px;
                border-radius: 50%;
                background-color: #007bff;
                color: #fff;
                font-size: 26px;
                box-shadow: 0 4px 10px rgba(0,0,0,0.3);
                transition: all 0.3s ease-in-out;
                z-index: 9999;
            }
            #chatBubble:hover {
                background-color: #0056b3;
                transform: scale(1.08);
            }

            /* Optional pulse animation */
            @keyframes pulse {
                0% { box-shadow: 0 0 0 0 rgba(0,123,255, 0.5); }
                70% { box-shadow: 0 0 0 10px rgba(0,123,255, 0); }
                100% { box-shadow: 0 0 0 0 rgba(0,123,255, 0); }
            }
            #chatBubble {
                animation: pulse 2s infinite;
            }
        </style>
    @endif
@endauth



@stack('scripts')
</body>
</html>
