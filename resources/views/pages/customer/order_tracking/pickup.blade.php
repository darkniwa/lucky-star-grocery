<div class="container px-1 px-md-4 mx-auto">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-center font-size-lg">
                    <h2>ORDER <span class="text-primary font-weight-bold">#{{ $tracking->order_number }}</span>
                    </h2>
                </div>
                <!-- Move the order date and chevron icon into a new div for alignment -->
                <div class="d-flex align-items-center">
                    <div class="order-details text-right">
                        <p class="mb-0 font-size-md">
                            <span class="font-weight-bold">Order Date:</span>
                            {{ $tracking->created_at->diffForHumans() }}
                        </p>
                    </div>
                    <!-- Add the "Expand/Collapse" button with Font Awesome icon in the card header -->
                    <button class="btn btn-link" id="toggleButton">
                        <i class="fas fa-chevron-up"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row d-flex justify-content-center">
                <div class="col-12">
                    <ul id="progressbar" class="text-center">
                        @if ($tracking->status == 'Successful Pick Up')
                            <li class="active step0" id="status1"></li>
                            <li class="active step0" id="status2"></li>
                            <li class="active step0" id="status3"></li>
                            <li class="active step0" id="status4"></li>
                        @elseif($tracking->status == 'Ready for Pick Up')
                            <li class="active step0" id="status1"></li>
                            <li class="active step0" id="status2"></li>
                            <li class="active step0" id="status3"></li>
                            <li class="step0" id="status4"></li>
                        @elseif($tracking->status == 'To Pack')
                            <li class="active step0" id="status1"></li>
                            <li class="active step0" id="status2"></li>
                            <li class="step0" id="status3"></li>
                            <li class="step0" id="status4"></li>
                        @else
                            <li class="active step0" id="status1"></li>
                            <li class="step0" id="status2"></li>
                            <li class="step0" id="status3"></li>
                            <li class="step0" id="status4"></li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="row justify-content-between top">
                <div class="row d-flex icon-content"> <i class="fas fa-receipt fa-4x icon"></i>
                    <div class="d-flex flex-column tracking-info">
                        <p class="font-weight-bold">Order Received</p>
                    </div>
                </div>
                <div class="row d-flex icon-content"> <i class="fas fa-cogs fa-4x icon"></i>
                    <div class="d-flex flex-column tracking-info">
                        <p class="font-weight-bold">Processing</p>
                    </div>
                </div>
                <div class="row d-flex icon-content"> <i class="fas fa-store fa-4x icon"></i>
                    <div class="d-flex flex-column tracking-info">
                        <p class="font-weight-bold">Ready for Pickup</p>
                    </div>
                </div>
                <div class="row d-flex icon-content"> <i class="fas fa-check-circle fa-4x icon"></i>
                    <div class="d-flex flex-column tracking-info">
                        <p class="font-weight-bold">Order Completed</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <!-- Add the "Pick Up QR Code" button in the card footer -->
            <button class="btn btn-primary open-modal btn-lg" data-toggle="modal" data-target="#qrCodeModal"
                data-qr="{{ $tracking->order_number }}" data-date="{{ $tracking->created_at->format('F j, Y h:i A') }}"
                data-products="{{ $tracking->getOrderDetails() }}"
                data-total="{{ $tracking->getPaymentRelation->total_cost }}"
                data-payment-option="{{ $tracking->mode_of_payment }}"
                data-payment-status="{{ $tracking->getPaymentRelation->status }}">Pick Up QR
                Code</button>
        </div>
    </div>
</div>
