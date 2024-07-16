@extends('layouts.customer_secondary')
@section('content')
    <!--Hero Section-->
    <div class="hero-section hero-background">
        <h1 class="page-title">Lucky Star Convenient Store Products</h1>
    </div>

    <!--Navigation section-->
    <div class="container">
        <nav class="biolife-nav">
            <ul>
                <li class="nav-item"><a href="{{ route('home') }}" class="permal-link">Home</a></li>
                <li class="nav-item"><span class="current-page">Products</span></li>
            </ul>
        </nav>
    </div>

    <div class="page-contain category-page no-sidebar">
        <div class="container">
            <div class="row">

                <!-- Main content -->
                <div id="main-content" class="main-content col-lg-12 col-md-12 col-sm-12 col-xs-12">

                    <div class="product-category grid-style">

                        <div id="top-functions-area" class="top-functions-area">
                            <form action="{{ route('products') }}" name="frm-refine" method="get" id="filter-form">
                                <div class="flt-item to-left group-on-mobile">
                                    <span class="flt-title">Filter</span>
                                    <a href="#" class="icon-for-mobile">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </a>
                                    <div class="wrap-selectors">
                                        <span class="title-for-mobile">Refine Products By</span>
                                        <div data-title="Price:" class="selector-item">
                                            <select name="price" class="selector" id="price-filter"
                                                onchange="document.getElementById('filter-form').submit()">
                                                <option value="all" {{ $selectedPrice === 'all' ? 'selected' : '' }}>
                                                    Price</option>
                                                <option value="1" {{ $selectedPrice === '1' ? 'selected' : '' }}>Less
                                                    than Php 50</option>
                                                <option value="2" {{ $selectedPrice === '2' ? 'selected' : '' }}>Php 50
                                                    - Php 100</option>
                                                <option value="3" {{ $selectedPrice === '3' ? 'selected' : '' }}>Php
                                                    100 - Php 200</option>
                                                <option value="4" {{ $selectedPrice === '4' ? 'selected' : '' }}>Php
                                                    200 - Php 500</option>
                                                <option value="5" {{ $selectedPrice === '5' ? 'selected' : '' }}>More
                                                    than Php 500</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="flt-item to-right">
                                    <span class="flt-title">Sort</span>
                                    <div class="wrap-selectors">
                                        <div class="selector-item orderby-selector">
                                            <select name="orderby" class="orderby" aria-label="Shop order"
                                                onchange="document.getElementById('filter-form').submit()">
                                                <option value="default"
                                                    {{ $selectedSorting === 'default' ? 'selected' : '' }}>
                                                    Default</option>
                                                <option value="price" {{ $selectedSorting === 'price' ? 'selected' : '' }}>
                                                    Price:
                                                    Low to High</option>
                                                <option value="price-desc"
                                                    {{ $selectedSorting === 'price-desc' ? 'selected' : '' }}>
                                                    Price: High to Low</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="row">
                            <ul class="products-list">
                                @foreach ($products as $product)
                                    <li class="product-item col-lg-3 col-md-3 col-sm-4 col-xs-6">
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
                                                <b class="categories">{{ $product['variation'] }} </b>
                                                <h4 class="product-title"><a href="#"
                                                        class="pr-name">{{ $product['product_name'] }}</a></h4>
                                                <div class="price" style="height: 24px">
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
                                                    <div class="sumary-product">
                                                        <div class="action-form text-center" style="width: 100%;">
                                                            <div class="quantity-box">
                                                                <span class="title">Quantity:</span>
                                                                <div class="qty-input">
                                                                    <input type="text" name="qty{{ $product->id }}"
                                                                        value="1" data-max_value="20"
                                                                        data-min_value="1" data-step="1"
                                                                        id="qty{{ $product->id }}">
                                                                    <a href="#" class="qty-btn btn-up"><i
                                                                            class="fa fa-caret-up"
                                                                            aria-hidden="true"></i></a>
                                                                    <a href="#" class="qty-btn btn-down"><i
                                                                            class="fa fa-caret-down"
                                                                            aria-hidden="true"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="buttons">
                                                        @if (Auth::check())
                                                            <div class="buttons">
                                                                <a class="btn add-to-cart-btn" id="{{ $product['id'] }}"><i
                                                                        class="fa fa-cart-arrow-down"
                                                                        aria-hidden="true"></i>add to cart</a>
                                                            </div>
                                                        @else
                                                            <div class="buttons">
                                                                <a href="/login" class="btn add-to-cart-btn"><i
                                                                        class="fa fa-cart-arrow-down"
                                                                        aria-hidden="true"></i>add to cart</a>
                                                            </div>
                                                        @endif
                                                        <a href="#" class="btn compare-btn"><i class="fa fa-random"
                                                                aria-hidden="true"></i></a>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>



                        {{ $products->links('inc.customer.pagination-links') }}

                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/seller/vendors/toastify/toastify.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/seller/vendors/toastify/toastify.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $('body').on('click', '.add-to-cart-btn', function() {
                var product_id = $(this).attr('id');
                var qty = $('#qty' + product_id).val();

                $.ajax({
                    data: {
                        product_id: product_id,
                        qty: qty
                    },
                    url: "{{ route('orders.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        if (data.error) {
                            Toastify({
                                text: data.message,
                                duration: 3000,
                                close: true,
                                gravity: "top",
                                position: "center",
                                backgroundColor: "#ff0033", // Red color for error
                            }).showToast();
                        } else {
                            Toastify({
                                text: "Successfully Added to Cart",
                                duration: 3000,
                                close: true,
                                gravity: "top",
                                position: "center",
                                backgroundColor: "#4fbe87",
                            }).showToast();
                        }
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });
            });

        });
    </script>
@endsection
