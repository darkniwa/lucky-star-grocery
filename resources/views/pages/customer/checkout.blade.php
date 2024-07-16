@extends('layouts.customer_secondary')
@section('content')
    <!--Hero Section-->
    <div class="hero-section hero-background">
        <h1 class="page-title">Checkout</h1>
    </div>

    <!--Navigation section-->
    <div class="container">
        <nav class="biolife-nav">
            <ul>
                <li class="nav-item"><a href="/home" class="permal-link">Home</a></li>
                <li class="nav-item"><a href="/orders" class="permal-link">Shopping Cart</a></li>
                <li class="nav-item"><span class="current-page">Checkout</span></li>
            </ul>
        </nav>
    </div>

    <div class="page-contain checkout">


        <!-- Main content -->
        <div id="main-content" class="main-content">
            <div class="container sm-margin-top-37px">
                @if ($errors->has('paymentFailed'))
                    <div class="alert alert-danger">
                        {{ $errors->first('paymentFailed') }}
                    </div>
                @endif

                <div class="row">
                    <form action="{{ route('orders.confirm') }}" name="frm-checkout" method="post" id="frm-checkout">
                        @csrf
                        <!--checkout progress box-->
                        <div class="col-lg-7 col-md-7 col-sm-6 col-xs-12">
                            <div class="checkout-progress-wrap">
                                <ul class="steps">
                                    <li class="step 1st">
                                        <div class="checkout-act">
                                            <h3 class="title-box"><span class="number">1</span>Customer</h3>
                                            <div class="box-content">
                                                <p class="txt-desc">Please double check your personal information for
                                                    delivery confirmation.</p>
                                                <div class="login-on-checkout">
                                                    <p class="form-row">
                                                        <label for="input_email" class="checkout_form_label">Customer Name:
                                                        </label>
                                                        <input id="customer-name" type="text" name="name"
                                                            value="{{ Auth::user()->display_name }}" disabled>
                                                    </p>
                                                    <p class="form-row">
                                                        <label for="input_email" class="checkout_form_label">Contact Number:
                                                        </label>
                                                        <input id="phone" type="text" name="name"
                                                            value="{{ Auth::user()->mobile }}" disabled>
                                                    </p>
                                                    <p class="msg">Incorrect Information? <a href="/account"
                                                            class="link-forward">Update Personal Information Here</a></p>

                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="step 2nd">
                                        <div class="checkout-act">
                                            <h3 class="title-box"><span class="number">2</span>Shipping Address</h3>
                                            <div class="box-content">
                                                <p class="txt-desc">Select delivery address</p>
                                                <div class="login-on-checkout">
                                                    @if (Auth::user()->addresses->count() > 0)
                                                        @foreach (Auth::user()->addresses as $address)
                                                            <p class="form-row">
                                                                <input type="radio" name="user_addresses_id"
                                                                    value="{{ $address->id }}" id="{{ $address->label }}">
                                                                <label for="{{ $address->label }}"
                                                                    class="checkout_form_label"><b>{{ ucfirst($address->label) }}
                                                                        Address: </b> {{ $address->getFormattedAddress() }}
                                                                </label>
                                                            </p>
                                                        @endforeach
                                                        <p class="form-row">
                                                            <input type="radio" name="user_addresses_id"
                                                                value="store_pickup" id="store_pickup">
                                                            <label for="store_pickup" class="checkout_form_label"><b>Pickup
                                                                    in Store</b></label>
                                                        </p>
                                                    @else
                                                        <p>No addresses found.</p>
                                                        <p class="form-row">
                                                            <input type="radio" name="user_addresses_id"
                                                                value="store_pickup" id="store_pickup">
                                                            <label for="store_pickup" class="checkout_form_label"><b>Pickup
                                                                    in Store</b></label>
                                                        </p>
                                                    @endif
                                                </div>
                                                <a href="{{ route('address.create', ['source' => 'checkout']) }}"
                                                    class="btn btn-primary btn-block" type="button"><i class="fa fa-plus"
                                                        aria-hidden="true"></i> Add Address</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="step 3rd">
                                        <div class="checkout-act">
                                            <h3 class="title-box"><span class="number">3</span>Mode of Payment</h3>

                                            <div class="box-content">
                                                <p class="txt-desc">Select mode of payment</p>
                                                <div class="login-on-checkout">
                                                    <p class="form-row">
                                                        <input type="radio" name="mode_of_payment" value="cod"
                                                            id="cod" checked>
                                                        <label for="cod" class="checkout_form_label">Cash on Delivery /
                                                            Over the Counter</label>
                                                    </p>
                                                    <p class="form-row">
                                                        <input type="radio" name="mode_of_payment" value="gcash"
                                                            id="gcash">
                                                        <label for="gcash" class="checkout_form_label">GCash</label>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!--Order Summary-->
                        <div
                            class="col-lg-5 col-md-5 col-sm-6 col-xs-12 sm-padding-top-48px sm-margin-bottom-0 xs-margin-bottom-15px">
                            <div class="order-summary sm-margin-bottom-80px">
                                <div class="title-block">
                                    <h3 class="title">Order Summary</h3>
                                    <a href="/orders" class="link-forward">Edit cart</a>
                                </div>
                                <div class="cart-list-box short-type">
                                    <ul class="cart-list">

                                        @foreach ($cart as $item)
                                            <li class="cart-elem">
                                                <div class="cart-item">
                                                    <div class="product-thumb">
                                                        <a class="prd-thumb" href="#">
                                                            <figure><img
                                                                    src="{{ asset('storage/uploads/images/' . $item->getProductRelation->image_folder . '/' . $item->getProductRelation->variation . '.jpg') }}"
                                                                    width="113" height="113" alt="shop-cart">
                                                            </figure>
                                                        </a>
                                                    </div>
                                                    <div class="info">
                                                        <span class="txt-quantity">{{ $item->quantity }}X</span>
                                                        <a href="#"
                                                            class="pr-name">{{ $item->getProductRelation->product_name }}
                                                            {{ $item->getProductRelation->variation }}</a>
                                                    </div>
                                                    <div class="price price-contain">
                                                        @if (empty($item->getProductRelation->discounted_price))
                                                            <ins><span class="price-amount"><span
                                                                        class="currencySymbol">Php
                                                                    </span>{{ number_format((float) $item->getProductRelation->price * $item->quantity, 2, '.', '') }}</span></ins>
                                                        @else
                                                            <ins><span class="price-amount"><span
                                                                        class="currencySymbol">Php
                                                                    </span>{{ number_format((float) $item->getProductRelation->discounted_price * $item->quantity, 2, '.', '') }}</span></ins>
                                                            <del><span class="price-amount"><span
                                                                        class="currencySymbol">Php
                                                                    </span>{{ number_format((float) $item->getProductRelation->price * $item->quantity, 2, '.', '') }}</span></del>
                                                        @endif

                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <ul class="subtotal">
                                        <li>
                                            <div class="subtotal-line">
                                                <b class="stt-name">Subtotal</b>
                                                <span class="stt-price">Php
                                                    {{ number_format((float) $total_cost, 2, '.', '') }}</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="subtotal-line">
                                                <b class="stt-name">Shipping</b>
                                                <span class="stt-price">Php {{ number_format($shipping_fee, 2) }}</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="subtotal-line">
                                                <b class="stt-name">total:</b>
                                                <span class="stt-price">Php
                                                    {{ number_format((float) $total_cost + $shipping_fee, 2, '.', '') }}</span>
                                            </div>
                                        </li>
                                        <div class="shpcart-subtotal-block proceed">
                                            <div class="btn-checkout">
                                                <a href="javascript:{}" id="proceed-btn" class="btn checkout">Proceed</a>

                                            </div>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#proceed-btn').click(function() {
                // Get values from input fields
                var customerName = $('#customer-name').val();
                var phone = $('#phone').val();
                var address = $('input[name=user_addresses_id]:checked').val();
                var payment = $('input[name=mode_of_payment]:checked').val();

                // Create an array to store missing fields
                var missingFields = [];

                // Check for missing fields
                if (customerName === '') {
                    missingFields.push('Customer Name');
                }
                if (phone === '') {
                    missingFields.push('Phone Number');
                }
                if (address === undefined) {
                    missingFields.push('Delivery Address');
                }
                if (payment === undefined) {
                    missingFields.push('Mode of Payment');
                }

                // If any fields are missing, show SweetAlert message
                if (missingFields.length > 0) {
                    var missingFieldsText = "Please fill in the following field" +
                        (missingFields.length > 1 ? "s" : "") +
                        ": " +
                        (missingFields.length > 1 ?
                            missingFields.slice(0, -1).join(", ") + " and " + missingFields.slice(-1) :
                            missingFields[0]);

                    Swal.fire({
                        icon: 'error',
                        title: 'Missing Information',
                        text: missingFieldsText,
                    });
                } else {
                    // Proceed with the checkout process
                    $('#frm-checkout').submit();
                }
            });
        });
    </script>
@endsection
