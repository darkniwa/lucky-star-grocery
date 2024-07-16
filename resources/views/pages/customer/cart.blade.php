@extends('layouts.customer_secondary')
@section('content')
    <!--Hero Section-->
    <div class="hero-section hero-background">
        <h1 class="page-title">My Shopping Cart</h1>
    </div>

    <!--Navigation section-->
    <div class="container">
        <nav class="biolife-nav">
            <ul>
                <li class="nav-item"><a href="{{ route('home') }}" class="permal-link">Home</a></li>
                <li class="nav-item"><span class="current-page">Shopping Cart</span></li>
            </ul>
        </nav>
    </div>

    <div class="page-contain shopping-cart">

        <!-- Main content -->
        <div id="main-content" class="main-content">
            <div class="container">

                <!--Cart Table-->
                <div class="shopping-cart-container">
                    <div class="row">
                        <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                            <h3 class="box-title">Your cart items</h3>
                            <form class="shopping-cart-form" action="#" method="post">
                                <table class="shop_table cart-form">
                                    <thead>
                                        <tr>
                                            <th class="product-name">Product Name</th>
                                            <th class="product-price">Price</th>
                                            <th class="product-quantity">Quantity</th>
                                            <th class="product-subtotal">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($cart as $item)
                                            <tr class="cart_item cart-item" id="cart-{{ $item->id }}">
                                                <td class="product-thumbnail" data-title="Product Name">
                                                    <a class="prd-thumb" href="#">
                                                        <figure><img width="113" height="113"
                                                                src="{{ asset('storage/uploads/images/' . $item->getProductRelation->image_folder . '/' . $item->getProductRelation->variation . '.jpg') }}"
                                                                alt="shipping cart"></figure>
                                                    </a>
                                                    <a class="prd-name"
                                                        href="#">{{ $item->getProductRelation->product_name }}
                                                        {{ $item->getProductRelation->variation }}</a>
                                                    <div class="action">
                                                        <a class="remove cart-remove-item" value="{{ $item->id }}"><i
                                                                class="fa fa-trash-o" aria-hidden="true"></i></a>
                                                    </div>
                                                </td>
                                                <td class="product-price" data-title="Price">
                                                    <div class="price price-contain">
                                                        <ins><span class="price-amount"><span class="currencySymbol">Php
                                                                </span><span class="item-price"
                                                                    id="item-price-{{ $item->id }}">@currency($item->getProductRelation->price)</span></span></ins>
                                                    </div>
                                                </td>
                                                <td class="product-quantity" data-title="Quantity">
                                                    <div class="quantity-box type1">
                                                        <div class="qty-input">
                                                            <input type="text" name="qty"
                                                                value="{{ $item->quantity }}"
                                                                data-max_value="{{ $item->getProductRelation->availability }}"
                                                                data-min_value="1" data-step="1"
                                                                id="item-quantity-{{ $item->id }}" class="item-quantity"
                                                                max="{{ $item->getProductRelation->availability }}">
                                                            <a href="#" class="qty-btn btn-up"
                                                                id='qty-btn-{{ $item->id }}'><i class="fa fa-caret-up"
                                                                    aria-hidden="true"></i></a>
                                                            <a href="#" class="qty-btn btn-down"
                                                                id='qty-btn-{{ $item->id }}'><i
                                                                    class="fa fa-caret-down" aria-hidden="true"></i></a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="product-subtotal" data-title="Total">
                                                    <div class="price price-contain">
                                                        <ins><span class="price-amount"><span class="currencySymbol">Php
                                                                </span><span class="item-total"
                                                                    id="item-total-{{ $item->id }}">0.00</span></span></ins>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach


                                        <tr class="cart_item wrap-buttons">
                                            <td class="wrap-btn-control" colspan="4">
                                                <a class="btn back-to-shop" href="/products">Back to Shop</a>
                                                <a class="btn btn-clear" type="reset" href="/orders/clear">clear all</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                            <div class="shpcart-subtotal-block">
                                <div class="subtotal-line">
                                    <b class="stt-name">Total <span class="sub">( <span id="total-qty"></span>
                                            items)</span></b>
                                    <span class="stt-price">Php <span id="total-price"></span></span>
                                </div>
                                <div class="btn-checkout">
                                    <a href="{{ route('orders.checkout') }}" class="btn checkout">Check out</a>
                                </div>
                                <div class="biolife-progress-bar">
                                    <table>
                                        <tr>
                                            <td class="first-position">
                                                <span class="index">Php 0</span>
                                            </td>
                                            <td class="mid-position">
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" style="width: 10%"
                                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </td>
                                            <td class="last-position">
                                                <span class="index">Php 2500</span>
                                            </td>
                                        </tr>
                                    </table>
                                    <p id="purchase-notice">Please note: A Minimum Order Amount of <code>Php 500</code> is
                                        required for purchases.</p>
                                    <p id="purchase-notice-shipping">Great news: You qualify for Free Shipping if your
                                        orders reach a total of <code>Php 2500</code>.</p>
                                    <p id="purchase-notice-congrats">Congratulations: You have reached the required amount
                                        for Free Shipping. <code>Shipping Fee is now waived</code>.</p>
                                </div>
                            </div>
                        </div>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="{{ asset('assets/seller/vendors/toastify/toastify.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            displayTotalPrice();


            $('.qty-btn').click(function() {

                setTimeout(() => {
                    var id = $(this).attr('id').replace('qty-btn-', '');
                    var qty = $('#item-quantity-' + id).val();
                    updateQuantity(id, qty);
                }, 0);
            });

            $('.item-quantity').on('change paste keyup', function() {
                setTimeout(() => {
                    var id = $(this).attr('id').replace('item-quantity-', '');
                    var qty = $('#item-quantity-' + id).val();

                    updateQuantity(id, qty);

                }, 0);

                var max = parseInt($(this).attr("max"));
                var min = parseInt($(this).data("min_value"));
                var value = parseInt($(this).val());

                if (isNaN(value) || value < min) {
                    value = min;
                    Toastify({
                        text: "Quantity cannot be less than " + min,
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#ff0033", // Red color for error
                    }).showToast();
                } else if (value > max) {
                    value = max;
                    Toastify({
                        text: "Quantity cannot exceed " + max,
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#ff0033", // Red color for error
                    }).showToast();
                }

                $(this).val(value);
            });

            $('body').on('click', '.cart-remove-item', function() {
                var item_id = $(this).attr("value");
                confirm("Are You sure want to remove this item?");

                $.ajax({
                    type: "DELETE",
                    url: "{{ url('orders') }}" + '/' + item_id,
                    success: function(data) {
                        setTimeout(() => {
                            $("#cart-" + item_id).remove();
                            displayTotalPrice();
                        }, 0);
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });
            });
        });

        function displayTotalPrice() {
            var items = $('.cart-item').map((_, el) => el.id.replace('cart-', '')).get();
            var total_price = 0;
            var total_qty = 0;
            items.forEach(id => {
                var price = parseFloat($('#item-price-' + id).text());
                var quantity = parseFloat($('#item-quantity-' + id).val());
                var item_total = parseFloat(price * quantity).toFixed(2);
                $('#item-total-' + id).text(item_total);
                total_price += parseFloat(item_total);
                total_qty += parseFloat(quantity);
            });
            $('#total-price').text(total_price);
            $('#total-qty').text(total_qty);

            var limit = parseFloat(total_price) / 2500 * 100;

            $('.progress-bar').css('width', limit + '%');
            if (total_price < 500) {
                $('.progress-bar').css('background-color', 'red');
                $('#purchase-notice').show();
                $('#purchase-notice-shipping').hide();
                $('#purchase-notice-congrats').hide();
                $('.checkout').hide();
            } else if (total_price >= 500 && total_price <= 2500) {
                $('.progress-bar').css('background-color', '#ffcc00');
                $('#purchase-notice').hide();
                $('#purchase-notice-shipping').show();
                $('#purchase-notice-congrats').hide();
                $('.checkout').show();
            } else {
                $('.progress-bar').css('background-color', '#05a503');
                $('#purchase-notice').hide();
                $('#purchase-notice-shipping').hide();
                $('#purchase-notice-congrats').show();
                $('.checkout').show();
            }
        }

        function updateQuantity(id, newValue) {
            $.ajax({
                type: "PUT",
                url: "{{ url('orders/') }}" + '/' + id + '?quantity=' + newValue,
                success: function(data) {
                    setTimeout(() => {
                        displayTotalPrice();
                    }, 0);
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        }
    </script>
@endsection
