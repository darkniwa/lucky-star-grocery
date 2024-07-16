@extends('layouts.seller')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Order Scanner</h3>
                    <p class="text-subtitle text-muted">Effortlessly scan QR codes to pick up and manage orders for
                        streamlined logistics.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="/orders">Orders</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Order Details</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        <section class="section">
            <div class="row">
                <div class="col-12">
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
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/seller/js/qr-scanner.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        // Function to execute when the DOM is ready
        $(document).ready(function() {
            // Get the result container element by ID
            var resultContainer = $('#qr-reader-results');
            var lastResult, countResults = 0;

            // Function to execute when a QR code is successfully scanned
            function onScanSuccess(decodedText, decodedResult) {
                if (decodedText !== lastResult) {
                    ++countResults;
                    lastResult = decodedText;
                    // Handle on success condition with the decoded message.
                    var order_number = decodedText.replace('pickup-', '');

                    $.ajax({
                        url: '/check-order-status/' + order_number,
                        type: 'GET',
                        success: function(response) {
                            if (response.status === 'Order is already picked up or completed') {
                                // Handle the case where the order is already picked up or completed
                                showAlert('This order is already picked up or completed.', 'warning');
                            } else if (response.status === "Order is not picked up or completed") {
                                $('#btn-qrscan-confirm').prop('disabled', false);
                                $('#header-info').text(order_number);
                                $('#order_number_success').prop('value', order_number);
                                $('#order_number_failed').prop('value', order_number);
                            }
                        },
                        error: function() {
                            // Handle the case where the AJAX request fails
                            showAlert('This QR Code is invalid.', 'error');
                        }
                    });

                }
            }

            // Create an instance of Html5QrcodeScanner and render it
            var html5QrcodeScanner = new Html5QrcodeScanner(
                "qr-reader", {
                    fps: 10,
                    qrbox: 250
                });
            // html5QrcodeScanner.render(onScanSuccess);

            html5QrcodeScanner.render(onScanSuccess, function(error) {
                // Handle errors here
                console.error(error);
            });

            // Add this code to display a SweetAlert2 alert
            function showAlert(message, type = 'info') {
                Swal.fire({
                    icon: type,
                    title: message,
                    showConfirmButton: false,
                    timer: 2000 // Auto close after 2 seconds
                });
            }

        });
    </script>
@endsection
