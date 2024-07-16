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
                            <li class="breadcrumb-item"><a href="/orders">Orders</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Order Details</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-8">
                    @if ($orders[0]->status == 'Order Confirmed')
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title"><i class="fas fa-clipboard-list"></i> Order Confirmed</h5>
                            </div>
                            <div class="card-body">
                                <p>Order has been confirmed by the buyer. This order is not yet ready for pick-up.</p>
                            </div>
                        </div>
                    @elseif ($orders[0]->status == 'To Pack')
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title"><i class="fas fa-clipboard-list"></i> Packing</h5>
                            </div>
                            <div class="card-body">
                                <p>Orders are currently being packed. It will be ready for pickup soon.</p>
                            </div>
                        </div>
                    @elseif ($orders[0]->status == 'Ready To Ship')
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title"><i class="fas fa-clipboard-list"></i> To Ship</h5>
                            </div>
                            <div class="card-body">
                                <p>Package is now ready to ship. Waiting for courier to pick-up and deliver the items.</p>
                                <form action="{{route('delivery.status.update', $order_number)}}" name="form-order-status" method="post" class="btn">
                                    @csrf
                                    <input type="text" value="Shipping" name="newOrderStatus" hidden>
                                    <button class="btn btn-success">Deliver Now</button>
                                </form>
                            </div>
                        </div>
                    @elseif ($orders[0]->status == 'Shipping')
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title"><i class="fas fa-shipping-fast"></i> Courier are on his way.</h5>
                            </div>
                            <div class="card-body">
                                <p>The courier is on his way to the buyer's address.</p>
                                <form action="{{route('delivery.status.update', $order_number)}}" name="form-order-status" method="post" class="btn">
                                    @csrf
                                    <input type="text" value="Delivered" name="newOrderStatus" hidden>
                                    <button class="btn btn-success">Success Delivery</button>
                                </form>

                                <form action="{{route('delivery.status.update', $order_number)}}" name="form-order-status" method="post" class="btn">
                                    @csrf
                                    <input type="text" value="Failed Delivery" name="newOrderStatus" hidden>
                                    <button class="btn btn-danger">Failed Delivery</button>
                                </form>
                            </div>
                        </div>
                    @elseif ($orders[0]->status == 'Cancelled')
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title"><i class="fas fa-times"></i> Cancelled</h5>
                            </div>
                            <div class="card-body">
                                <p>Order has been cancelled.</p>
                            </div>
                        </div>
                    @elseif ($orders[0]->status == 'Order Arrived')
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title"><i class="fas fa-check-circle"></i> Order Arrived</h5>
                            </div>
                            <div class="card-body">
                                <p>The order has been received by the customer. <br>Waiting for customer confirmation.</p>
                            </div>
                        </div>
                    @elseif ($orders[0]->status == 'Delivered')
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title"><i class="fas fa-check-circle"></i> Delivered</h5>
                            </div>
                            <div class="card-body">
                                <p>The orders has been delivered successfully.</p>
                            </div>
                        </div>
                    @elseif ($orders[0]->status == 'Successful Pick Up')
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title"><i class="fas fa-check-circle"></i> Successful Pick Up</h5>
                            </div>
                            <div class="card-body">
                                <p>Orders has been picked up successfully.</p>
                            </div>
                        </div>
                    @elseif ($orders[0]->status == 'Failed Pick Up')
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title"><i class="fas fa-times"></i> Failed Pick Up</h5>
                            </div>
                            <div class="card-body">
                                <p>The orders didn't picked up by the customer.</p>
                            </div>
                        </div>
                    @elseif ($orders[0]->status == 'Ready for Pick Up')
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title"><i class="fas fa-check-circle"></i> Pick Up Ready</h5>
                            </div>
                            <div class="card-body">
                                <p>This order are ready for pick up in store location. Waiting for the customer to arrive.</p>
                            </div>
                        </div>
                    @elseif ($orders[0]->status == 'Failed Delivery')
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title"><i class="fas fa-times"></i> Failed Delivery</h5>
                            </div>
                            <div class="card-body">
                                <p>For some reason, courier not able to delivery the items.</p>
                            </div>
                        </div>
                    @endif

                </div>
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
            </div>
        </section>

        <section class="section">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title"><i class="fas fa-exclamation-circle"></i> Buyer Delivery History</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <p>For buyers with low % of successful deliveries, you might want to contact them to confirm the order.</p>
                                </div>
                                <div class="col-6">
                                    <p class="alert alert-light"><i class="fas fa-box-open"></i> No Deliveries</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title"><i class="fas fa-user"></i> Customer Information</h5>
                        </div>
                        <div class="card-body">
                            <p>&emsp;{{ $orders[0]->getUserRelation->display_name }} - {{ $orders[0]->getUserRelation->mobile }}
                        </div>

                    </div>
                </div>

                <div class="col-8">
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
                                                <img src="{{ asset('storage/uploads/images/' . $order->getProductRelation->image_folder . '/' . $order->getProductRelation->variation . '.jpg') }}" alt="Image" class="img-thumbnail" width="75px" height="75px">
                                            </td>
                                            <td>{{ $order->getProductRelation->product_name }} {{ $order->getProductRelation->variation }}</td>
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
