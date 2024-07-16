@extends('layouts.customer_secondary')
@section('content')
    <!--Hero Section-->
    <div class="hero-section hero-background">
        <h1 class="page-title">Order Tracking</h1>
    </div>

    <!--Navigation section-->
    <div class="container">
        <nav class="biolife-nav">
            <ul>
                <li class="nav-item"><a href="/home" class="permal-link">Home</a></li>
                <li class="nav-item"><a href="/orders" class="permal-link">My Orders</a></li>
                <li class="nav-item"><span class="current-page">Order Tracking</span></li>
            </ul>
        </nav>
    </div>

    <div class="page-contain checkout">

        <!-- Main content -->
        <div id="main-content" class="main-content">
            <div class="container">
                <div class="row">
                    @foreach ($orders as $tracking)
                        @if ($tracking->user_addresses_id === null)
                            @include('pages.customer.order_tracking.pickup')
                        @else
                            @include('pages.customer.order_tracking.delivery')
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @include('pages.customer.order_tracking.e-receipt')
@endsection

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            color: #000;
            overflow-x: hidden;
            height: 100%;
        }

        .card {
            z-index: 0;
            background-color: #ECEFF1;
            margin-bottom: 20px;
            border-radius: 10px
        }

        .top {
            padding-top: 40px;
        }

        #progressbar {
            margin-bottom: 30px;
            overflow: hidden;
            color: #455A64;
            padding-left: 0px;
            margin-top: 30px
        }

        #progressbar li {
            list-style-type: none;
            font-size: 13px;
            width: 25%;
            float: left;
            position: relative;
            font-weight: 400
        }

        #progressbar .step0:before {
            font-family: FontAwesome;
            content: "\f10c";
            color: #fff
        }

        #progressbar li:before {
            width: 40px;
            height: 40px;
            line-height: 45px;
            display: block;
            font-size: 20px;
            background: #C5CAE9;
            border-radius: 50%;
            margin: auto;
            padding: 0px
        }

        #progressbar li:after {
            content: '';
            width: 100%;
            height: 12px;
            background: #C5CAE9;
            position: absolute;
            left: 0;
            top: 16px;
            z-index: -1
        }

        #progressbar li:last-child:after {
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
            position: absolute;
            left: -50%
        }

        #progressbar li:nth-child(2):after,
        #progressbar li:nth-child(3):after {
            left: -50%
        }

        #progressbar li:first-child:after {
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
            position: absolute;
            left: 50%
        }

        #progressbar li:last-child:after {
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px
        }

        #progressbar li:first-child:after {
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px
        }

        #progressbar li.active:before,
        #progressbar li.active:after {
            background: #651FFF
        }

        #progressbar li.active:before {
            font-family: FontAwesome;
            content: "\f00c"
        }

        .icon {
            width: 60px;
            height: 60px;
            margin-right: 15px
        }

        .icon-content {
            padding-bottom: 20px
        }

        .tracking-info p {
            font-size: medium;
        }


        @media screen and (max-width: 992px) {
            .icon-content {
                width: 50%
            }
        }

        .font-size-lg {
            font-size: 24px;
            /* Adjust as needed */
        }

        .font-size-md {
            font-size: 16px;
            /* Adjust as needed */
        }

        .address {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
        }
    </style>

    <style>
        /* Increase font size for the store name and address */
        .modal-body .text-center h3 {
            font-size: 24px;
        }

        .modal-body .text-center p {
            font-size: 18px;
        }

        /* Increase font size for receipt details */
        .modal-body h5,
        .modal-body p {
            font-size: 18px;
        }

        .modal-body span {
            font-size: 15px;
        }

        /* Increase font size for list items */
        .modal-body .list-group-item {
            font-size: 16px;
        }

        /* Increase font size for total amount */
        .modal-body h4 span {
            font-size: 20px;
        }

        .modal-title {
            font-size: 24px;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ asset('client/assets/js/jquery.qrcode.min.js') }}"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
    <script>
        $(document).ready(function() {
            @if (!empty($orders[0]))
                var orderNumber = {!! json_encode($orders[0]['order_number']) !!};
            @else
                var orderNumber = null; // or any default value you prefer
            @endif
            var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
            });

            var channel = pusher.subscribe('order_tracking.' + orderNumber);
            channel.bind('OrderTracking', function(data) {
                if (data.OrderStatus === "Order Arrived" || data.OrderStatus === "Delivered") {
                    $('#status1').attr('class', 'active step0');
                    $('#status2').attr('class', 'active step0');
                    $('#status3').attr('class', 'active step0');
                    $('#status4').attr('class', 'active step0');
                } else if (data.OrderStatus === "Shipping") {
                    $('#status1').attr('class', 'active step0');
                    $('#status2').attr('class', 'active step0');
                    $('#status3').attr('class', 'active step0');
                    $('#status4').attr('class', 'step0');
                } else if (data.OrderStatus === "Ready To Ship") {
                    $('#status1').attr('class', 'active step0');
                    $('#status2').attr('class', 'active step0');
                    $('#status3').attr('class', 'step0');
                    $('#status4').attr('class', 'step0');
                } else {
                    $('#status1').attr('class', 'active step0');
                    $('#status2').attr('class', 'step0');
                    $('#status3').attr('class', 'step0');
                    $('#status4').attr('class', 'step0');
                }
            });
        });

        $(document).ready(function() {
            // When a button with class 'open-modal' is clicked
            $('.open-modal').click(function() {
                // Get the value of data-qr attribute from the clicked button
                var qrCodeValue = $(this).data('qr');
                var orderDate = $(this).data('date');
                var products = $(this).data('products');
                var total_cost = $(this).data('total');
                var paymentOption = $(this).data('payment-option');
                var paymentStatus = $(this).data('payment-status');

                // Clear the previous QR code and product list, if any
                $('#pickup-qrcode').empty();
                $('#product-list').empty();

                // Set the QR code value
                $('#pickup-qrcode-value').val(qrCodeValue);
                $('#details-order-number').text(qrCodeValue);
                $('#details-order-date').text(orderDate);
                $('#details-total-cost').text(parseFloat(total_cost).toFixed(2));


                var $paymentOptionElement = $('#details-payment-option');
                var $paymentStatusElement = $('#details-payment-status');

                if (paymentOption === 'cod') {
                    $paymentOptionElement.text('Over the Counter');
                } else if (paymentOption === 'gcash') {
                    $paymentOptionElement.text('GCash');
                }

                if (paymentStatus === 'Pending') {
                    $paymentStatusElement.addClass('badge-warning').text('Pending');
                } else if (paymentStatus === 'Completed') {
                    $paymentStatusElement.addClass('badge-success').text('Paid');
                }

                // Generate and display the QR code
                generateQRCode(qrCodeValue, 'pickup-qrcode');

                for (var i = 0; i < products.length; i++) {
                    var product = products[i];
                    var productName = product.product_name;
                    var variation = product.variation;
                    var price = product.price;
                    var quantity = product.quantity;

                    var listItem = $(
                        '<li class="list-group-item d-flex justify-content-between align-items-center"></li>'
                    );
                    listItem.append(productName + ' (' + variation + ') x ' + quantity);
                    listItem.append('<span class="badge badge-primary badge-pill">₱' + (price * quantity)
                        .toFixed(2) + '</span>');

                    $('#product-list').append(listItem);
                }
            });
        });


        // Function to generate and display the QR code
        function generateQRCode(qrCodeValue, targetElementId) {
            var qrcode = new QRCode(document.getElementById(targetElementId), {
                text: 'pickup-' + qrCodeValue,
                width: 180,
                height: 180
            });
        }

        $(document).ready(function() {
            // Initially, hide all card bodies
            $(".card .card-body").hide();

            // Toggle the card body when the button is clicked
            $(".card-header #toggleButton").click(function() {
                // Find the closest card-body element to the clicked button
                var cardBody = $(this).closest('.card').find('.card-body');

                // Slide toggle only the card body of the current card
                cardBody.slideToggle();

                // Toggle the icon (up/down chevron) within the current card header
                $(this).find('i').toggleClass('fa-chevron-up fa-chevron-down');
            });
        });

        $(document).ready(function() {
            // Function to save modal content (excluding footer) as an image
            function saveAsImage() {
                // Get the modal content element
                var modalContent = document.querySelector('.modal-content');

                // Exclude the modal footer from the screenshot
                var modalFooter = modalContent.querySelector('.modal-footer');
                modalFooter.style.display = 'none'; // Hide the footer temporarily

                // Use html2canvas to capture a screenshot of the modal content
                html2canvas(modalContent).then(function(canvas) {
                    // Restore the visibility of the modal footer
                    modalFooter.style.display = 'block';

                    // Convert the canvas to a data URL
                    var imgData = canvas.toDataURL('image/png');

                    // Create a temporary download link
                    var downloadLink = document.createElement('a');
                    downloadLink.href = imgData;
                    downloadLink.download = 'receipt.png';
                    document.body.appendChild(downloadLink);

                    // Trigger a click event on the download link to initiate the download
                    downloadLink.click();

                    // Clean up the temporary download link
                    document.body.removeChild(downloadLink);
                });
            }

            // Add click event listener to the "Save as Image" button
            $('#saveAsImageBtn').click(function() {
                saveAsImage();
            });
        });
    </script>
@endsection
