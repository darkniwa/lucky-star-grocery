@php
    use Carbon\Carbon;
@endphp

@extends('layouts.seller')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Lucky Star Orders</h3>
                    <p class="text-subtitle text-muted">Efficiently manage your order list for seamless order processing and
                        customer satisfaction.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Orders</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        <section class="section">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-pills nav-fill" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="new-orders-tab" data-bs-toggle="tab" href="#new-orders"
                                        role="tab" aria-controls="new-orders" aria-selected="true">
                                        New Orders
                                        <span
                                            class="badge bg-danger">{{ $newOrdersCount != 0 ? $newOrdersCount : '' }}</span>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="to-pack-tab" data-bs-toggle="tab" href="#to-pack" role="tab"
                                        aria-controls="to-pack" aria-selected="false">To Pack
                                        <span class="badge bg-danger">{{ $toPackCount != 0 ? $toPackCount : '' }}</span>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="to-ship-tab" data-bs-toggle="tab" href="#to-ship" role="tab"
                                        aria-controls="to-ship" aria-selected="false">To Ship
                                        <span
                                            class="badge bg-danger">{{ $readyToShipCount != 0 ? $readyToShipCount : '' }}</span>
                                    </a>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="shipping-tab" data-bs-toggle="tab" href="#shipping"
                                        role="tab" aria-controls="shipping" aria-selected="false">Shipping
                                        <span class="badge bg-danger">{{ $shippingCount != 0 ? $shippingCount : '' }}</span>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="for-pickup-tab" data-bs-toggle="tab" href="#for-pickup"
                                        role="tab" aria-controls="for-pickup" aria-selected="false">Pick up
                                        <span
                                            class="badge bg-danger">{{ $readyForPickUpCount != 0 ? $readyForPickUpCount : '' }}</span>
                                    </a>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="delivered-tab" data-bs-toggle="tab" href="#delivered"
                                        role="tab" aria-controls="delivered" aria-selected="false">Delivered
                                    </a>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="cancellation-tab" data-bs-toggle="tab" href="#cancellation"
                                        role="tab" aria-controls="cancellation" aria-selected="false">Cancellation
                                    </a>
                                </li>


                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="failed-delivery-tab" data-bs-toggle="tab"
                                        href="#failed-delivery" role="tab" aria-controls="failed-delivery"
                                        aria-selected="false">Failed Delivery
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content" id="myTabContent">

                                <div class="tab-pane fade show active" id="new-orders" role="tabpanel"
                                    aria-labelledby="new-orders-tab">
                                    @include('pages.seller.orders.tabs.new_orders')
                                </div>
                                <div class="tab-pane fade" id="to-pack" role="tabpanel" aria-labelledby="to-pack-tab">
                                    @include('pages.seller.orders.tabs.to_pack')
                                </div>
                                <div class="tab-pane fade" id="to-ship" role="tabpanel" aria-labelledby="to-ship-tab">
                                    @include('pages.seller.orders.tabs.to_ship')
                                </div>
                                <div class="tab-pane fade" id="shipping" role="tabpanel"
                                    aria-labelledby="shipping-tab">
                                    @include('pages.seller.orders.tabs.shipping')
                                </div>
                                <div class="tab-pane fade" id="for-pickup" role="tabpanel"
                                    aria-labelledby="for-pickup-tab">
                                    @include('pages.seller.orders.tabs.pickup')
                                </div>
                                <div class="tab-pane fade" id="delivered" role="tabpanel"
                                    aria-labelledby="delivered-tab">
                                    @include('pages.seller.orders.tabs.delivered')
                                </div>
                                <div class="tab-pane fade" id="cancellation" role="tabpanel"
                                    aria-labelledby="cancellation-tab">
                                    @include('pages.seller.orders.tabs.cancellation')
                                </div>
                                <div class="tab-pane fade" id="return-or-refund" role="tabpanel"
                                    aria-labelledby="return-or-refund-tab">
                                    @include('pages.seller.orders.tabs.return_and_refund')
                                </div>
                                <div class="tab-pane fade" id="failed-delivery" role="tabpanel"
                                    aria-labelledby="failed-delivery-tab">
                                    @include('pages.seller.orders.tabs.failed_delivery')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
