@extends('layouts.customer_primary')

@section('content')
    <!-- Page Contain -->
    <div class="page-contain">

        <!-- Main content -->
        <div id="main-content" class="main-content">

            <!-- Block 01: Main slide block-->
            {{-- <div class="main-slide block-slider">
                <ul class="biolife-carousel nav-none-on-mobile"
                    data-slick='{"arrows": true, "dots": false, "slidesMargin": 0, "slidesToShow": 1, "infinite": true, "speed": 800, "autoplay": true, "autoplaySpeed": 3000}'>
                    <li>
                        <div class="slide-contain slider-opt03__layout01 mode-03 slide-bgr-mode03-02">
                            <div class="media">
                            </div>
                            <div class="text-content">
                                <i class="first-line">Pomegranate</i>
                                <h3 class="second-line">Protein Smoothie</h3>
                                <p class="third-line">A blend of freshly squeezed green apple & fruits</p>
                                <p class="buttons">
                                    @if (Auth::check())
                                        <a href="/products" class="btn btn-bold">Shop now</a>
                                    @else
                                        <a href="/login" class="btn btn-bold">Shop now</a>
                                    @endif
                                    <a href="/products" class="btn btn-thin">View Products</a>
                                </p>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="slide-contain slider-opt03__layout01 mode-03 black-color slide-bgr-mode03-01">
                            <div class="media"></div>
                            <div class="text-content">
                                <i class="first-line">Pomegranate</i>
                                <h3 class="second-line">Fresh Juice</h3>
                                <p class="third-line">A blend of freshly squeezed green apple & fruits</p>
                                <p class="buttons">
                                    @if (Auth::check())
                                        <a href="/products" class="btn btn-bold">Shop now</a>
                                    @else
                                        <a href="/login" class="btn btn-bold">Shop now</a>
                                    @endif
                                    <a href="/products" class="btn btn-thin">View Products</a>
                                </p>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="slide-contain slider-opt03__layout01 mode-03 slide-bgr-mode03-03">
                            <div class="media">
                            </div>
                            <div class="text-content">
                                <i class="first-line">Pomegranate</i>
                                <h3 class="second-line">Fresh Juice. Nature Drinks</h3>
                                <p class="third-line">A blend of freshly squeezed green apple & fruits</p>
                                <p class="buttons">
                                    @if (Auth::check())
                                        <a href="/products" class="btn btn-bold">Shop now</a>
                                    @else
                                        <a href="/login" class="btn btn-bold">Shop now</a>
                                    @endif
                                    <a href="/products" class="btn btn-thin">View Products</a>
                                </p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div> --}}

            <div class="main-slide block-slider">
                <ul class="biolife-carousel nav-none-on-mobile"
                    data-slick='{"arrows": true, "dots": false, "slidesMargin": 0, "slidesToShow": 1, "infinite": true, "speed": 800, "autoplay": true, "autoplaySpeed": 3000}'>
                    @foreach ($carouselData as $slide)
                        <li>
                            <div class="slide-contain slider-opt03__layout01 mode-03 slide-bgr-mode03-01">
                                <div class="media" style="background-image: url('/storage/{{ $slide['image'] }}');">
                                </div>
                                <div class="text-content">
                                    <i class="first-line">{{ $slide['first_line'] }}</i>
                                    <h3 class="second-line">{{ $slide['second_line'] }}</h3>
                                    <p class="third-line">{{ $slide['third_line'] }}</p>
                                    <p class="buttons">
                                        @if (Auth::check())
                                            <a href="{{ $slide['buttons'][0]['link'] }}" class="btn btn-bold">Shop now</a>
                                        @else
                                            <a href="/login" class="btn btn-bold">Shop now</a>
                                        @endif
                                        <a href="{{ $slide['buttons'][1]['link'] }}" class="btn btn-thin">View Products</a>
                                    </p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Block 03: Product Tab-->
            <div class="product-tab z-index-20 sm-margin-top-49px xs-margin-top-80px">
                <div class="container">
                    <div class="biolife-title-box biolife-title-box__icon-at-top-style hidden-icon-on-mobile">
                        <span class="icon-at-top biolife-icon icon-organic"></span>
                        <span class="subtitle">All the best item for You</span>
                        <h3 class="main-title">Bestseller Products</h3>
                    </div>
                    <div class="biolife-tab biolife-tab-contain sm-margin-top-32px">

                        <div class="tab-content">
                            <div id="tab02_1st" class="tab-contain active">
                                <ul class="products-list biolife-carousel nav-center-02 nav-none-on-mobile eq-height-contain"
                                    data-slick='{"rows":1 ,"arrows":true,"dots":false,"infinite":true,"speed":400,"slidesMargin":10,"slidesToShow":4, "responsive":[{"breakpoint":1200, "settings":{ "slidesToShow": 4}},{"breakpoint":992, "settings":{ "slidesToShow": 3, "slidesMargin":30}},{"breakpoint":768, "settings":{ "slidesToShow": 2, "rows":2, "slidesMargin":15}}]}'>
                                    @foreach ($best_seller as $product)
                                        <li class="product-item">
                                            <div class="contain-product layout-default">
                                                <div class="product-thumb">
                                                    <a href="/product/{{ $product['id'] }}" class="link-to-product">
                                                        <div class="square-image-container">
                                                            <img src="{{ asset('storage/uploads/images/' . $product['image_folder'] . '/' . $product['variation'] . '.jpg') }}"
                                                                alt="Product Image" class="product-thumbnail">
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="info">
                                                    <b class="categories">{{ $product['variation'] }}</b>
                                                    <h4 class="product-title"><a href="#"
                                                            class="pr-name">{{ $product['product_name'] }}</a></h4>
                                                    <div class="price ">

                                                        @if (empty($product['discounted_price']))
                                                            <ins><span class="price-amount"><span class="currencySymbol">Php
                                                                    </span>{{ number_format((float) $product['price'], 2, '.', '') }}</span></ins>
                                                        @else
                                                            <ins><span class="price-amount"><span class="currencySymbol">Php
                                                                    </span>{{ number_format((float) $product['discounted_price'], 2, '.', '') }}</span></ins>
                                                            <del><span class="price-amount"><span class="currencySymbol">Php
                                                                    </span>{{ number_format((float) $product['price'], 2, '.', '') }}</span></del>
                                                        @endif
                                                    </div>
                                                    <div class="slide-down-box">
                                                        <p class="message">All products are carefully selected to ensure
                                                            food safety.</p>
                                                        <div class="buttons">
                                                            @if (Auth::check())
                                                                <a class="btn add-to-cart-btn" id="{{ $product['id'] }}"><i
                                                                        class="fa fa-cart-arrow-down"
                                                                        aria-hidden="true"></i>add to cart</a>
                                                            @else
                                                                <a href="/login" class="btn add-to-cart-btn"><i
                                                                        class="fa fa-cart-arrow-down"
                                                                        aria-hidden="true"></i>add to cart</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Block 04: Banners-->
            <div class="banner-block md-margin-top-61px sm-margin-bottom-89px xs-margin-top-60px">
                <div class="biolife-banner special-02 biolife-banner__special-02">
                    <div class="container">
                        <div class="banner-contain">
                            <div class="thumb">
                                <a href="#" class="link"><img src="/storage/{{ $specialOfferData->image }}"
                                        width="753" height="517" alt=""></a>
                            </div>
                            <div class="text-content">
                                <i class="text01">{{ $specialOfferData->text01 }}</i>
                                <b class="text02">{{ $specialOfferData->text02 }}</b>
                                <span class="text03">{{ $specialOfferData->text03 }}</span>
                                <span class="text04">{{ $specialOfferData->text04 }}</span>
                                <div class="product-detail">
                                    <h4 class="product-name">{{ $specialOfferData->product_detail->product_name }}</h4>
                                    <div class="price price-contain">
                                        <ins><span class="price-amount"><span
                                                    class="currencySymbol">{{ $specialOfferData->product_detail->price->currencySymbol }}</span>{{ $specialOfferData->product_detail->price->amount }}</span></ins>
                                    </div>
                                    <p class="measure">{{ $specialOfferData->product_detail->measure }}</p>
                                    <div class="buttons">
                                        <a href="{{ $specialOfferData->product_detail->buttons[0]->link }}"
                                            class="btn add-to-cart-btn"
                                            tabindex="-1">{{ $specialOfferData->product_detail->buttons[0]->text }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Block 05: Banner Promotion-->
            <div class="banner-promotion xs-margin-top-0 sm-margin-top-60px xs-margin-top-100">
                <div class="biolife-banner promotion6 biolife-banner__promotion6">
                    <div class="banner-contain">
                        <div class="media">
                            <div class="img-moving position-1">
                                <a href="#" class="banner-link">
                                    <img src="{{ asset('client/assets/images/home-01/bn-promotion-6-child-01.png') }}"
                                        width="568" height="760" alt="img msv">
                                </a>
                            </div>
                            <div class="img-moving position-2">
                                <img src="{{ asset('client/assets/images/home-01/bn-promotion-6-child-02.png') }}"
                                    width="745" height="682" alt="img msv">
                            </div>
                        </div>
                        <div class="text-content">
                            <i class="text1">Drinks</i>
                            <b class="text2">Get Yours Now!</b>
                            <p class="buttons">
                                <a href="/products" class="btn btn-thin">Shop Now</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Block 10: Brands-->
            <div class="brand-slide sm-margin-top-76px sm-margin-bottom-77px xs-margin-top-80px xs-margin-bottom-80px">
                <div class="container">
                    <ul class="biolife-carousel nav-center-bold nav-none-on-mobile"
                        data-slick='{"rows":1,"arrows":true,"dots":false,"infinite":false,"speed":400,"slidesMargin":30,"slidesToShow":4, "responsive":[{"breakpoint":1200, "settings":{ "slidesToShow": 4}},{"breakpoint":992, "settings":{ "slidesToShow": 3, "slidesMargin": 10}},{"breakpoint":768, "settings":{ "slidesToShow": 2, "slidesMargin": 10}}]}'>
                        <li>
                            <div class="biolife-brd-container transparent-effect">
                                <a href="#" class="link">
                                    <figure><img src="{{ asset('client/assets/images/home-01/brd-01.png') }}"
                                            width="199" height="110" alt=""></figure>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="biolife-brd-container transparent-effect">
                                <a href="#" class="link">
                                    <figure><img src="{{ asset('client/assets/images/home-01/brd-02.png') }}"
                                            width="199" height="110" alt=""></figure>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="biolife-brd-container transparent-effect">
                                <a href="#" class="link">
                                    <figure><img src="{{ asset('client/assets/images/home-01/brd-03.png') }}"
                                            width="199" height="110" alt=""></figure>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="biolife-brd-container transparent-effect">
                                <a href="#" class="link">
                                    <figure><img src="{{ asset('client/assets/images/home-01/brd-04.png') }}"
                                            width="199" height="110" alt=""></figure>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="biolife-brd-container transparent-effect">
                                <a href="#" class="link">
                                    <figure><img src="{{ asset('client/assets/images/home-01/brd-01.png') }}"
                                            width="199" height="110" alt=""></figure>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="biolife-brd-container transparent-effect">
                                <a href="#" class="link">
                                    <figure><img src="{{ asset('client/assets/images/home-01/brd-02.png') }}"
                                            width="199" height="110" alt=""></figure>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="biolife-brd-container transparent-effect">
                                <a href="#" class="link">
                                    <figure><img src="{{ asset('client/assets/images/home-01/brd-03.png') }}"
                                            width="199" height="110" alt=""></figure>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="biolife-brd-container transparent-effect">
                                <a href="#" class="link">
                                    <figure><img src="{{ asset('client/assets/images/home-01/brd-04.png') }}"
                                            width="199" height="110" alt=""></figure>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

        </div>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('body').on('click', '.add-to-cart-btn', function() {
                var product_id = $(this).attr('id');

                $.ajax({
                    data: {
                        product_id: product_id
                    },
                    url: "{{ route('orders.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        $('#' + product_id).hide();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });
            })

            // Set initial slide and total number of slides
            var currentSlide = 0;
            var totalSlides = $('.carousel-slide').length;

            // Function to switch to the next slide
            function nextSlide() {
                $('.carousel-slide').eq(currentSlide).removeClass('active');
                currentSlide = (currentSlide + 1) % totalSlides;
                $('.carousel-slide').eq(currentSlide).addClass('active');
            }

            // Set interval to trigger next slide every 3 seconds
            var interval = setInterval(nextSlide, 3000);

            // Pause interval when clicking on a slide
            $('.carousel-slide').click(function() {
                clearInterval(interval); // Stop the interval
                interval = setInterval(nextSlide, 3000); // Restart the interval
            });

        });
    </script>
@endsection
