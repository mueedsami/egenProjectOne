<!-- HEADER -->
<header class="header trans_300" style="height: 0;">
    <div class="main_nav_container">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-right">
                    <div class="logo_container">
                        <a href="{{ url('/') }}" style="color:white">
                            Outfi<span>TR</span>
                        </a>
                    </div>

                    <nav class="navbar">
                        <ul class="navbar_menu" style="margin-top: -15px;">
                            <li>
                                <a href="{{ url('/') }}" style="color:white; font-size: 20px; font-family: 'Cormorant Garamond', Georgia, serif;">
                                    ANASAYFA
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/categories') }}" style="color:white; font-size: 20px; font-family: 'Cormorant Garamond', Georgia, serif;">
                                    ALIŞVERİŞ
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/contact') }}" style="color:white; font-size: 20px; font-family: 'Cormorant Garamond', Georgia, serif;">
                                    İLETİŞİM
                                </a>
                            </li>
                        </ul>

                        <ul class="navbar_user" style="margin-top: -15px;">
                            <li>
                                <a href="#">
                                    <i class="fa fa-search" style="color:white" aria-hidden="true"></i>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/login') }}">
                                    <i class="fa fa-user" style="color:white" aria-hidden="true"></i>
                                </a>
                            </li>
                            <li class="checkout">
                                <a href="{{ url('/cart') }}">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                    <span id="checkout_items" class="checkout_items"></span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
