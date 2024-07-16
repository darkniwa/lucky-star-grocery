<!-- Preloader -->
<div id="biof-loading">
    <div class="biof-loading-center">
        <div class="biof-loading-center-absolute">
            <div class="dot dot-one"></div>
            <div class="dot dot-two"></div>
            <div class="dot dot-three"></div>
        </div>
    </div>
</div>

<!-- HEADER -->
<header id="header" class="header-area style-01 layout-03">
    @if (!Auth::check())
        <div class="header-top bg-main hidden-xs">
            <div class="container">
                <div class="top-bar left">
                    <ul class="horizontal-menu">
                        <li><a href="{{ Auth::check() ? '/account' : '#' }}"><i
                                    class="fa fa-{{ Auth::check() ? 'user' : 'envelope' }}"
                                    aria-hidden="true"></i>{{ Auth::check() ? Auth::user()->display_name : 'support@luckystargroceries.com' }}</a>
                        </li>
                    </ul>
                </div>
                <div class="top-bar right">
                    @if (Auth::check())
                        <ul class="horizontal-menu">
                            <li><a href="{{ route('logout') }}" class="login-link"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </ul>
                    @else
                        <ul class="horizontal-menu">
                            <li><a href="/login" class="login-link"><i
                                        class="biolife-icon icon-login"></i>Login/Register</a></li>
                        </ul>
                    @endif

                </div>
            </div>
        </div>
    @endif

    <div class="header-middle biolife-sticky-object ">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-2 col-md-6 col-xs-6">
                    <a href="/" class="biolife-logo"><img src="{{ asset('client/assets/images/logo.png') }}"
                            alt="Lucky Star logo" width="135" height="34"></a>
                </div>
                <div class="col-lg-6 col-md-7 hidden-sm hidden-xs">
                    <div class="primary-menu">
                        <ul class="menu biolife-menu clone-main-menu clone-primary-menu" id="primary-menu"
                            data-menuname="main menu">
                            <li class="menu-item"><a href="/">Home</a></li>
                            <li class="menu-item"><a href="/products">Products</a></li>
                            <li class="menu-item"><a href="/contact">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-md-6 col-xs-6">
                    <div class="biolife-cart-info">
                        <div class="mobile-search">
                            <a href="javascript:void(0)" class="open-searchbox"><i
                                    class="biolife-icon icon-search"></i></a>
                            <div class="mobile-search-content">
                                <form action="#" class="form-search" name="mobile-seacrh" method="get">
                                    <a href="#" class="btn-close"><span
                                            class="biolife-icon icon-close-menu"></span></a>
                                    <input type="text" name="product-search" class="input-text" value=""
                                        placeholder="Search here..." autocomplete="off">
                                    <button type="submit" class="btn-submit">go</button>
                                </form>
                            </div>
                        </div>
                        @if (Auth::check())
                            <div class="minicart-block layout-02">
                                <div class="minicart-contain">
                                    <div class="icon-contain">
                                        <div class="span-index">
                                            <i class="icon-cart-mini biolife-icon"></i>
                                            <span class="sub-total">My Cart</span>
                                        </div>
                                        <a href="/orders" class="btn-to-cart">Go</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="mobile-menu-toggle">
                            <a class="btn-toggle" data-object="open-mobile-menu" href="javascript:void(0)">
                                <span></span>
                                <span></span>
                                <span></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom hidden-sm hidden-xs">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    <div class="vertical-menu vertical-category-block">
                        <div class="block-title">
                            <span class="menu-icon">
                                <span class="line-1"></span>
                                <span class="line-2"></span>
                                <span class="line-3"></span>
                            </span>
                            <span class="menu-title">Categories</span>
                            <span class="angle" data-tgleclass="fa fa-caret-down"><i class="fa fa-caret-up"
                                    aria-hidden="true"></i></span>
                        </div>
                        <div class="wrap-menu">
                            <ul class="menu clone-main-menu">
                                <li class="menu-item"><a href="/products" class="menu-title">All</a></li>
                                @foreach ($categories as $category)
                                    <li class="menu-item"><a href="/products?category={{ $category->id }}"
                                            class="menu-title">{{ $category->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-8 padding-top-2px">
                    <div class="header-search-bar layout-01">
                        <form action="#" class="form-search" name="desktop-seacrh" method="get">
                            <input type="text" name="product-search" class="input-text" value=""
                                placeholder="Search here..." autocomplete="off">
                            <button type="submit" class="btn-submit"><i
                                    class="biolife-icon icon-search"></i></button>
                        </form>
                    </div>
                    <div class="live-info">
                        @if (Auth::check())
                            {{-- User dropdown --}}
                            <div class="vertical-menu vertical-category-block vertical-category-block-2">
                                <div class="block-title">
                                    <span class="menu-title menu-title-user">{{ Auth::user()->display_name }} </span>
                                    <span class="angle" data-tgleclass="fa fa-caret-down"><i class="fa fa-caret-up"
                                            aria-hidden="true"></i></span>
                                </div>
                                <div class="wrap-menu">
                                    <ul class="menu clone-main-menu">
                                        <li class="menu-item"><a href="/account" class="menu-title">My Profile</a>
                                        </li>
                                        <li class="menu-item"><a href="/address" class="menu-title">Address</a></li>
                                        <li class="menu-item"><a href="/orders/tracking" class="menu-title">My
                                                Orders</a></li>
                                        <li class="menu-item"><a href="{{ route('logout') }}" class="menu-title"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                        </li>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </ul>
                                </div>
                            </div>
                        @else
                            <p class="telephone"><i class="fa fa-phone" aria-hidden="true"></i><b
                                    class="phone-number">(043) 784-3987</b></p>
                            <p class="working-time">Mon-Fri: 8:30am-7:30pm; Sat-Sun: 9:30am-4:30pm</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
