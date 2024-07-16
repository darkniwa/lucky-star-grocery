<section class="section">
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered " id="table1">
                <thead>
                    <tr>
                        <th>Order Number</th>
                        <th>Customer Name</th>
                        <th>Delivery Address</th>
                        <th>Mode of Payment</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        @if ($order->status == 'Delivered')
                            <tr>
                                <td>
                                    <a class="link-secondary"
                                        href="{{ route('orders.show', $order->order_number) }}">
                                        {{ $order->order_number }}
                                    </a>
                                </td>
                                <td>{{ $order->getCustomerRelation->first_name . ' ' . $order->getCustomerRelation->last_name != ' ' ? $order->getCustomerRelation->first_name . ' ' . $order->getCustomerRelation->last_name : $order->display_name }}
                                </td>
                                <td>{{ $order->deliveryAddress ? $order->deliveryAddress->getFormattedAddress() : 'Pickup in Store Location' }}</td>
                                <td>{{ $order->user_addresses_id === null ? 'Over the Counter' : $order->mode_of_payment }}</td>
                                <td>{{ $order->status }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>