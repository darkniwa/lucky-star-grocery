@extends('layouts.seller')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Package Deliveries</h3>
                    <p>Effortlessly monitor and manage the status of incoming and outgoing package deliveries, ensuring
                        timely and secure handling of shipments.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Package Deliveries</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        <section id="form-and-scrolling-components">
            <div class="row justify-content-md-center">

                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title"><i class="fas fa-clipboard-list"></i> Scan QR Code</h5>
                        </div>
                        <div class="card-body">
                            <div id="qr-reader" style="width:100%"></div>
                            <div id="qr-reader-results"></div>
                            <br>
                            <div class="form-group">

                                <!-- Button trigger for login form modal -->
                                <button type="button" class="btn btn-outline-success col-12" data-bs-toggle="modal"
                                    data-bs-target="#inlineForm" disabled id="btn-qrscan-confirm">
                                    Confirm
                                </button>

                                <!--login form Modal -->
                                <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog"
                                    aria-labelledby="myModalLabel33" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel33">Order No: <label
                                                        id="header-info"></label></h4>
                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <i data-feather="x"></i>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <center>
                                                    <h5>Please Proceed to Payment!</h5>

                                                    <form action="{{ route('order.scan.proceed') }}"
                                                        name="form-order-status" method="post" class="btn">
                                                        @csrf
                                                        <input type="text" id="order_number_success" name="orderNumber"
                                                            hidden>
                                                        <input type="text" value="Successful Pick Up"
                                                            name="newOrderStatus" hidden>
                                                        <button class="btn btn-success">Payment Complete</button>
                                                    </form>

                                                    <form action="{{ route('order.scan.proceed') }}"
                                                        name="form-order-status" method="post" class="btn">
                                                        @csrf
                                                        <input type="text" id="order_number_failed" name="orderNumber"
                                                            hidden>
                                                        <input type="text" value="Failed Pick Up" name="newOrderStatus"
                                                            hidden>
                                                        <button class="btn btn-danger"> Failed Pick up</button>
                                                    </form>
                                                </center>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light-secondary"
                                                    data-bs-dismiss="modal">
                                                    <i class="bx bx-x d-block d-sm-none"></i>
                                                    <span class="d-none d-sm-block">Close</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    @if (session()->has('error'))
                        <div class="alert alert-danger alert-dismissible show fade">
                            <b>Error! </b> {{ session()->get('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="form-group">
                                    <h4 class="card-title">Enter Order Number</h4>
                                    <p> Manually enter the order number.</p>
                                    <!-- Button trigger for Order Finder modal -->
                                    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                        data-bs-target="#modalOrderFinder">
                                        Launch Order Finder
                                    </button>

                                    <!--Order Finder Modal -->
                                    <div class="modal fade text-left" id="modalOrderFinder" tabindex="-1" role="dialog"
                                        aria-labelledby="myModalLabel33" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel33">Order Finder</h4>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <form action="{{ route('delivery.check') }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <label>Order Number: </label>
                                                        <div class="form-group">
                                                            <input type="text" placeholder="Enter order number"
                                                                class="form-control" name="OrderNumber" autofocus>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light-secondary"
                                                            data-bs-dismiss="modal">
                                                            <i class="bx bx-x d-block d-sm-none"></i>
                                                            <span class="d-none d-sm-block">Close</span>
                                                        </button>
                                                        <button type="submit" class="btn btn-primary ml-1">
                                                            <i class="bx bx-check d-block d-sm-none"></i>
                                                            <span class="d-none d-sm-block">Find</span>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section">


            <div class="card">
                <div class="card-header">
                    <h6>Courier Dispatch List</h6>
                </div>
                <div class="card-body">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th>Order Number</th>
                                <th>Mode of Payment</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($deliveries as $delivery)
                                @if ($delivery->getOrderRelation->status == 'Shipping')
                                    <tr>
                                        <td><a
                                                href="{{ route('delivery.show', $delivery->order_number) }}">{{ $delivery->order_number }}</a>
                                        </td>
                                        <td>{{ $delivery->getOrderRelation->mode_of_payment }}</td>
                                        <td>{{ $delivery->getOrderRelation->status }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group"
                                                aria-label="Basic example">
                                                <form
                                                    action="{{ route('delivery.status.update', $delivery->order_number) }}"
                                                    name="form-order-status" method="post" class="btn">
                                                    @csrf
                                                    <input type="text" value="Delivered" name="newOrderStatus" hidden>
                                                    <button class="btn btn-outline-success">Success Delivery</button>
                                                </form>
                                                <form
                                                    action="{{ route('delivery.status.update', $delivery->order_number) }}"
                                                    name="form-order-status" method="post" class="btn">
                                                    @csrf
                                                    <input type="text" value="Failed Delivery" name="newOrderStatus"
                                                        hidden>
                                                    <button class="btn btn-outline-danger">Failed Delivery</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h6>Pending Pickup List</h6>
                </div>
                <div class="card-body">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th>Order Number</th>
                                <th>Mode of Payment</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                @if ($order->status == 'Ready To Ship')
                                    <tr>
                                        <td>{{ $order->order_number }}</td>
                                        <td>{{ $order->mode_of_payment }}</td>
                                        <td>{{ $order->status }}</td>
                                        <td>
                                            <a href="{{ route('delivery.show', $order->order_number) }}"
                                                class="btn btn-secondary">View</a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </section>
    </div>
@endsection


@section('scripts')
    <script src="{{ asset('assets/seller/js/qr-scanner.min.js') }}"></script>
    <script src="{{ asset('assets/seller/vendors/jquery/jquery.min.js') }}"></script>
    <script>
        function docReady(fn) {
            // see if DOM is already available
            if (document.readyState === "complete" ||
                document.readyState === "interactive") {
                // call on next available tick
                setTimeout(fn, 1);
            } else {
                document.addEventListener("DOMContentLoaded", fn);
            }
        }

        docReady(function() {
            var resultContainer = document.getElementById('qr-reader-results');
            var lastResult, countResults = 0;

            function onScanSuccess(decodedText, decodedResult) {
                if (decodedText !== lastResult) {
                    ++countResults;
                    lastResult = decodedText;
                    // Handle on success condition with the decoded message.
                    console.log(`Scan result ${decodedText}`, decodedResult);
                    var order_number = decodedText.replace('pickup-', '');
                    $('#btn-qrscan-confirm').prop('disabled', false);
                    $('#header-info').text(order_number);
                    $('#order_number_success').prop('value', order_number);
                    $('#order_number_failed').prop('value', order_number);
                }
            }

            var html5QrcodeScanner = new Html5QrcodeScanner(
                "qr-reader", {
                    fps: 10,
                    qrbox: 250
                });
            html5QrcodeScanner.render(onScanSuccess);
        });
    </script>
@endsection
