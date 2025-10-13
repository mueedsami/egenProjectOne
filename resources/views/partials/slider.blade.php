<div class="main_slider">
    <div class="swiper-container">
        <div class="swiper-wrapper">

            {{-- ======= VIDEO SLIDE ======= --}}
            <div class="swiper-slide">
                <section class="showcase position-relative">
                    <div class="video-container">
                        <a href="{{ url('categories') }}">
                            <video autoplay muted loop playsinline style="width:100%; height:600px; object-fit:cover;">
                                <source src="{{ asset('template/videos/main_page_slider_video.mp4') }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </a>
                    </div>

                    <div class="content position-absolute top-50 start-50 translate-middle text-center text-white">
                        <h6 style="font-family:'Cormorant Garamond', Georgia, serif;">
                            <small>Sonbahar / Kış Koleksiyonu - 2020</small>
                        </h6>
                        <h1 style="font-size:100px; font-family:'Cormorant Garamond', Georgia, serif;">
                            <a href="{{ url('categories') }}" class="text-white text-decoration-none">YENI SEZON</a>
                        </h1>
                    </div>
                </section>
            </div>

            {{-- ======= IMAGE SLIDES ======= --}}
            <div class="swiper-slide" style="background-image:url('{{ asset('template/images/example3.jpg') }}'); background-size:cover; background-position:center;"></div>
            <div class="swiper-slide" style="background-image:url('{{ asset('template/images/example1.jpg') }}'); background-size:cover; background-position:center;"></div>

        </div>

        {{-- Controls --}}
        <div class="swiper-scrollbar"></div>
        <div class="swiper-button-next" style="color:#fe4c50"></div>
        <div class="swiper-button-prev" style="color:#fe4c50"></div>
    </div>
</div>

{{-- Swiper JS --}}
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper('.swiper-container', {
        slidesPerView: 1,
        spaceBetween: 1,
        autoplay: {
            delay: 24000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        scrollbar: {
            el: '.swiper-scrollbar',
            hide: true,
        },
    });
</script>
