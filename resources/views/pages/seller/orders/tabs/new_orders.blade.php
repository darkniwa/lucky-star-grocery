<section class="section">
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered " id="table1">
                <thead>
                    <tr>
                        <th>Tracking Number</th>
                        <th>Customer Name</th>
                        <th>Mode of Payment</th>
                        <th>Creation Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        @if ($order->status == 'Order Confirmed')
                            <tr>
                                <td>
                                    <a class="link-secondary" href="{{ route('orders.show', $order->order_number) }}">
                                        {{ $order->order_number }}
                                    </a>
                                </td>
                                <td>{{ $order->getCustomerRelation->first_name . ' ' . $order->getCustomerRelation->last_name != ' ' ? $order->getCustomerRelation->first_name . ' ' . $order->getCustomerRelation->last_name : $order->display_name }}
                                </td>
                                <td>{{ $order->user_addresses_id === null ? 'Over the Counter' : $order->mode_of_payment }}</td>
                                <td>{{ Carbon\Carbon::parse($order->created_at)->diffForHumans() }}
                                </td>
                                <td>
                                    <a class="btn btn-outline-success"
                                        href="{{ route('orders.show', $order->order_number) }}">View
                                        Order</a>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="5">No orders available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
