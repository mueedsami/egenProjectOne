@extends('layouts.app')

@section('title', 'Home')

@section('content')
    {{-- =================== SLIDER =================== --}}
    @includeIf('partials.slider') {{-- optional, include only if exists --}}

    {{-- =================== CATEGORIES / BANNERS =================== --}}
    <div class="banner">
        {{-- keep your existing category/banner HTML here --}}
    </div>

    {{-- =================== NEW ARRIVALS =================== --}}
    <div class="new_arrivals">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <div class="section_title new_arrivals_title">
                        <h2>YENİ GELENLER</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="product-grid d-flex flex-wrap justify-content-center">
                        @forelse($products as $product)
                            @php
                                // Preload all images (so we can use first and second)
                                $images = $product->relationLoaded('images') ? $product->images : $product->images()->get();
                                $primary = $images->firstWhere('is_primary', true) ?? $images->first();
                                $secondary = $images->count() > 1 ? $images->skip(1)->first() : null;
                            @endphp

                            <div class="product-item m-3 position-relative" style="width:250px;">
                                <div class="product product_filter position-relative overflow-hidden">

                                    {{-- Product image with hover swap --}}
                                    <div class="product_image position-relative" style="height:250px; overflow:hidden;">
                                        <a href="{{ route('product.show', $product->slug) }}">
                                            <img
                                                src="{{ $primary ? asset('storage/' . $primary->image_url) : asset('images/no-image.png') }}"
                                                alt="{{ $product->name }}"
                                                class="img-fluid w-100 main-image"
                                                style="object-fit:cover; transition:opacity 0.3s ease;"
                                            >
                                            @if($secondary)
                                                <img
                                                    src="{{ asset('storage/' . $secondary->image_url) }}"
                                                    alt="{{ $product->name }}"
                                                    class="img-fluid w-100 hover-image position-absolute top-0 start-0"
                                                    style="object-fit:cover; opacity:0; transition:opacity 0.3s ease;"
                                                >
                                            @endif
                                        </a>
                                    </div>

                                    {{-- Hover effect script --}}
                                    <script>
                                        document.addEventListener("DOMContentLoaded", () => {
                                            document.querySelectorAll('.product-item').forEach(item => {
                                                const main = item.querySelector('.main-image');
                                                const hover = item.querySelector('.hover-image');
                                                if (hover) {
                                                    item.addEventListener('mouseenter', () => hover.style.opacity = 1);
                                                    item.addEventListener('mouseleave', () => hover.style.opacity = 0);
                                                }
                                            });
                                        });
                                    </script>

                                    {{-- Tag bubble --}}
                                    <div class="product_bubble product_bubble_left product_bubble_green d-flex flex-column align-items-center">
                                        <span>Yeni</span>
                                    </div>

                                    {{-- Product info --}}
                                    <div class="product_info text-center mt-2">
                                        <h6 class="product_name mb-1">
                                            <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                                        </h6>

                                        <div class="product_price">
                                            {{ number_format($product->price, 2) }} ₺
                                            @if($product->discount_price)
                                                <span class="text-muted text-decoration-line-through">
                                                    {{ number_format($product->discount_price, 2) }} ₺
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Add to cart / view button --}}
                                <div class="red_button add_to_cart_button mt-2">
                                    <a href="{{ route('product.show', $product->slug) }}">See Product</a>
                                </div>
                            </div>
                        @empty
                            <p class="text-center w-100">Henüz ürün bulunmamaktadır.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- =================== BENEFITS =================== --}}
    <div class="benefit">
        <div class="container">
            <div class="row benefit_row">
                <div class="col-lg-3 benefit_col">
                    <div class="benefit_item d-flex flex-row align-items-center">
                        <div class="benefit_icon"><i class="fa fa-truck"></i></div>
                        <div class="benefit_content"><h6>Ücretsiz Kargo</h6><p>100 ₺ üzerine ücretsiz kargo.</p></div>
                    </div>
                </div>
                <div class="col-lg-3 benefit_col">
                    <div class="benefit_item d-flex flex-row align-items-center">
                        <div class="benefit_icon"><i class="fa fa-money"></i></div>
                        <div class="benefit_content"><h6>Hızlı Teslimat</h6><p>En kısa sürede kargonuz evinizde.</p></div>
                    </div>
                </div>
                <div class="col-lg-3 benefit_col">
                    <div class="benefit_item d-flex flex-row align-items-center">
                        <div class="benefit_icon"><i class="fa fa-undo"></i></div>
                        <div class="benefit_content"><h6>45 Gün İçinde İade</h6><p>İade süresi 45 gündür.</p></div>
                    </div>
                </div>
                <div class="col-lg-3 benefit_col">
                    <div class="benefit_item d-flex flex-row align-items-center">
                        <div class="benefit_icon"><i class="fa fa-clock-o"></i></div>
                        <div class="benefit_content"><h6>Her Gün Hizmet</h6><p>08:00 - 21:00</p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- =================== NEWSLETTER =================== --}}
    <div class="newsletter">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="newsletter_text d-flex flex-column justify-content-center">
                        <h4>Bülten</h4>
                        <p>Bültenimize abone olun, ilk alışverişte %20 indirim kazanın.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <form action="#">
                        <div class="newsletter_form d-flex align-items-center justify-content-end">
                            <input id="newsletter_email" type="email" placeholder="Email" required>
                            <button id="newsletter_submit" type="submit" class="newsletter_submit_btn trans_300">Abone Ol</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
