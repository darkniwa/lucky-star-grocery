@extends('layouts.courier')
@section('content')
    <div class="page-heading">
        <h3>Notifications</h3>
    </div>
    <div class="page-content">
        {{-- <section class="row">
        


        <div class="col-12 col-lg-9">
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon purple">
                                        <i class="bi bi-cart-check-fill"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">New Orders</h6>
                                    <h6 class="font-extrabold mb-0">{{$confirmedOrders}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon blue">
                                        <i class="bi bi-card-list"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Processing Orders</h6>
                                    <h6 class="font-extrabold mb-0">{{$processingOrders}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon green">
                                        <i class="bi bi-truck"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Ready to Ship</h6>
                                    <h6 class="font-extrabold mb-0">{{$readyToShip}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon red">
                                        <i class="bi bi-box-seam"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Item for Pick up</h6>
                                    <h6 class="font-extrabold mb-0">{{$readyForPickUp}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-3">
            <div class="card">
                <div class="card-body py-4 px-5">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-xl">
                          
                            <img src="{{Auth::user()->getCustomerRelation->picture}}" alt="Profile">
                        </div>
                        <div class="ms-3 name">
                            <h5 class="font-bold">{{Auth::user()->display_name}}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-lg-9">
            <div class="card">
                <div class="card-header">
                    <h4>Monthly Sales Report</h4>
                </div>
                <div class="card-body">
                    <div id="chart-profile-visit"></div>
                </div>
            </div>
        </div>
            


        <div class="col-12 col-lg-3">
            <div class="row" id="table-borderless">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Recent Orders</h4>
                        </div>
                        <div class="card-content">
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recentCustomer as $key => $order)
                                        <tr>
                                            <td class="text-bold-500">{{$key+1}}</td>
                                            <td class="text-bold-500">{{$order->getCustomerRelation->first_name.' '.$order->getCustomerRelation->last_name}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




    </section> --}}

        <div class="container">
            <div class="row">
                <div class="col-lg-12 right">
                    <div class="box shadow-sm rounded bg-white mb-3">
                        <div class="box-title border-bottom p-3">
                            <h6 class="m-0">Unread</h6>
                        </div>
                        <div class="box-body p-0">
                            @foreach (Auth::user()->unreadNotifications as $notification)
                                <div class="p-3 d-flex align-items-center bg-light border-bottom osahan-post-header">
                                    <a href="{{ route('delivery.show', $notification->data['order_number']) }}">
                                        <div class="font-weight-bold mr-3">
                                            <div class="text-truncate"><b>READY TO SHIP</b></div>
                                            <div class="text-truncate">ORDER NUMBER: {{ $notification->data['order_number'] }}</div>
                                            <div class="small"> {{ Carbon\Carbon::parse($notification->created_at)->diffForHumans() }} </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="box shadow-sm rounded bg-white mb-3">
                        <div class="box-title border-bottom p-3">
                            <h6 class="m-0">Recent</h6>
                        </div>
                        <div class="box-body p-0">
                            @foreach (Auth::user()->notifications as $notification)
                                @if ($notification->read_at !== null)
                                    <div class="p-3 d-flex align-items-center bg-light border-bottom osahan-post-header">
                                        <a href="{{ route('delivery.show', $notification->data['order_number']) }}" class="{{$orders->where('order_number', $notification->data['order_number'])->first()->status == 'Order Arrived' ? 'text-secondary' : 'text-primary'}}">
                                            <div class="font-weight-bold mr-3">
                                                <div class="text-truncate"><b>{{ $orders->where('order_number', $notification->data['order_number'])->first()->status }}</b></div>
                                                <div class="text-truncate">ORDER NUMBER: {{ $notification->data['order_number'] }}</div>
                                                <div class="small"> {{ Carbon\Carbon::parse($notification->created_at)->diffForHumans() }} </div>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{ Auth::user()->unreadNotifications->markAsRead() }}
@endsection

@section('styles')
    <style>
        body {
            margin-top: 20px;
            background-color: #f0f2f5;
        }

        .dropdown-list-image {
            position: relative;
            height: 2.5rem;
            width: 2.5rem;
        }

        .dropdown-list-image img {
            height: 2.5rem;
            width: 2.5rem;
        }

        .btn-light {
            color: #2cdd9b;
            background-color: #e5f7f0;
            border-color: #d8f7eb;
        }
    </style>
@endsection
