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
                            <br>
                            <span class="font-weight-bold">Delivery Address:</span>
                            <span class="address">{{ $tracking->deliveryAddress->getFormattedAddress() }}</span>
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

                        @if ($tracking->status == 'Order Arrived' || $tracking->status == 'Delivered')
                            <li class="active step0" id="status1"></li>
                            <li class="active step0" id="status2"></li>
                            <li class="active step0" id="status3"></li>
                            <li class="active step0" id="status4"></li>
                        @elseif($tracking->status == 'Shipping')
                            <li class="active step0" id="status1"></li>
                            <li class="active step0" id="status2"></li>
                            <li class="active step0" id="status3"></li>
                            <li class="step0" id="status4"></li>
                        @elseif($tracking->status == 'Ready To Ship')
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
                <div class="row d-flex icon-content">
                    <i class="fas fa-cogs icon fa-4x"></i>
                    <div class="d-flex flex-column tracking-info">
                        <p class="font-weight-bold">Processing</p>
                    </div>
                </div>
                <div class="row d-flex icon-content">
                    <i class="fas fa-box icon fa-4x"></i>
                    <div class="d-flex flex-column tracking-info">
                        <p class="font-weight-bold">Order Packed</p>
                    </div>
                </div>
                <div class="row d-flex icon-content">
                    <i class="fas fa-truck icon fa-4x"></i>
                    <div class="d-flex flex-column tracking-info">
                        <p class="font-weight-bold">Courier On the Way</p>
                    </div>
                </div>
                <div class="row d-flex icon-content">
                    <i class="fas fa-clipboard-check icon fa-4x"></i>
                    <div class="d-flex flex-column tracking-info">
                        <p class="font-weight-bold">Order Delivered</p>
                    </div>
                </div>
            </div>
        </div>

        @if ($tracking->status == 'Order Arrived')
            <div class="row d-flex justify-content-between">
                <div class="d-flex">
                    <form action="{{ route('orders.received.success') }}" method="POST">
                        @csrf
                        <input type="hidden" name="OrderNumber" value="{{ $tracking->order_number }}">
                        <button type="submit" class="btn btn-lg btn-success">Order
                            Received</button>
                    </form>
                    &emsp;
                    <form action="{{ route('orders.received.failed') }}" method="POST">
                        @csrf
                        <input type="hidden" name="OrderNumber" value="{{ $tracking->order_number }}">
                        <button type="submit" class="btn btn-lg btn-danger">Not Arrived
                            Yet</button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
