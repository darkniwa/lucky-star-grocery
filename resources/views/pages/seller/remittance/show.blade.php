@extends('layouts.seller')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Order Details</h3>
                    <p class="text-subtitle text-muted">Tracking number: #{{ $order_number }}</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/manager">Home</a></li>
                            <li class="breadcrumb-item"><a href="/remittance">Remittance</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Order Details</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title"><i class="fas fa-hashtag"></i> Order ID</h5>
                        </div>
                        <div class="card-body">
                            <p>&emsp;{{ $order_number }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title"><i class="fas fa-user"></i> Customer Information</h5>
                        </div>
                        <div class="card-body">
                            <p>&emsp;{{ $orders[0]->getUserRelation->display_name }} ({{ $orders[0]->getUserRelation->mobile }})
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title"><i class="fas fa-truck"></i> Delivered By</h5>
                        </div>
                        <div class="card-body">
                            @if ($orders[0]->remittance && $orders[0]->remittance->getCollectorUserRelation)
                                <p>&emsp;{{ $orders[0]->remittance->getCollectorUserRelation->display_name }}</p>
                            @else
                                <p class="text-danger">&emsp;Not Delivered Yet</p>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <section class="section">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title"><i class="fas fa-map-marker-alt"></i> Delivery Address</h5>
                        </div>
                        <div class="card-body">
                            {{-- <p>{{ $orders[0]->deliveryAddress->getFormattedAddress() }}</p> --}}
                            <p>{{ optional($orders[0]->deliveryAddress)->getFormattedAddress() ?? '' }}</p>
                        </div>

                    </div>
                </div>

                <div class="col-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title"><i class="fas fa-shopping-basket"></i> Cart List</h5>
                        </div>

                        <div class="card-body">
                            <table class="table table-md">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Image</th>
                                        <th>Product(s)</th>
                                        <th>Unit Price</th>
                                        <th>Quantity</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $key => $order)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <img src="{{ asset('storage/uploads/images/' . $order->getProductRelation->image_folder . '/' . $order->getProductRelation->variation . '.jpg') }}"
                                                    alt="Image" class="img-thumbnail" width="75px" height="75px">
                                            </td>
                                            <td>{{ $order->getProductRelation->product_name }}
                                                {{ $order->getProductRelation->variation }}</td>
                                            <td>{{ $order->getProductRelation->price }}</td>
                                            <td>{{ $order->quantity }}</td>
                                            <td>{{ $order->getProductRelation->price * $order->quantity }}</td>
                                        </tr>
                                    @endforeach
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title"><i class="fas fa-money-check"></i> Payment Information</h5>
                        </div>

                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th>Order Subtotal</th>
                                    <td>
                                        @php
                                            $subtotal = 0;
                                            $shipping_fee = 50;
                                            foreach ($orders as $order) {
                                                $subtotal += $order->quantity * $order->getProductRelation->price;
                                            }
                                        @endphp
                                        {{ $subtotal }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Shipping Subtotal</th>
                                    <td>{{ $shipping_fee }}</td>
                                </tr>
                                <th>
                                    <tr>
                                        <th>Amount To Pay (COD)</th>
                                        <td>Php {{ $subtotal + $shipping_fee }}</td>
                                    </tr>
                                </th>

                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/seller/vendors/fontawesome/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/seller/css/style.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/seller/vendors/fontawesome/all.min.js') }}"></script>
@endsection
