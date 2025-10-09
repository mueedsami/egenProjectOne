@extends('layouts.app')

@section('title', 'Home')

@section('content')
    {{-- Slider --}}
    @include('partials.slider') {{-- optional, if you make slider partial later --}}

    {{-- Categories / banners --}}
    <div class="banner">
        ... keep your existing category HTML here ...
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
                <div class="product-item m-3" style="width:250px;">
                    <div class="product product_filter">
                        <div class="product_image">
                            <a href="{{ route('product.show', $product->slug) }}">
                                <img src="{{ $product->image_url ? asset('storage/' . $product->image_url) : asset('template/images/product_1.png') }}" 
                                     alt="{{ $product->name }}">
                            </a>
                        </div>

                        <div class="product_bubble product_bubble_left product_bubble_green d-flex flex-column align-items-center">
                            <span>Yeni</span>
                        </div>

                        <div class="product_info text-center">
                            <h6 class="product_name">
                                <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                            </h6>

                            <div class="product_price">
                                {{ number_format($product->price, 2) }} ₺
                                @if($product->discount_price)
                                    <span>{{ number_format($product->discount_price, 2) }} ₺</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="red_button add_to_cart_button">
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

    {{-- Benefit + Newsletter sections --}}
    ... paste those from your HTML unchanged ...
@endsection
