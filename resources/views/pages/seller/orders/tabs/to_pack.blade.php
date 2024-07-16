<section class="section">
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered " id="table1">
                <thead>
                    <tr>
                        <th>Order Number</th>
                        <th>Customer Name</th>
                        <th>Mode of Payment</th>
                        <th>Last Update</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        @if ($order->status == 'To Pack')
                            <tr>
                                <td>
                                    <a class="link-secondary" href="{{ route('orders.show', $order->order_number) }}">
                                        {{ $order->order_number }}
                                    </a>
                                </td>
                                <td>{{ $order->getCustomerRelation->first_name . ' ' . $order->getCustomerRelation->last_name != ' ' ? $order->getCustomerRelation->first_name . ' ' . $order->getCustomerRelation->last_name : $order->display_name }}
                                </td>
                                <td>{{ $order->user_addresses_id === null ? 'Over the Counter' : $order->mode_of_payment }}</td>
                                <td>{{ Carbon\Carbon::parse($order->updated_at)->diffForHumans() }}
                                </td>
                                <td>
                                    @if ($order->user_addresses_id === null)
                                        <form action="{{ route('order.update.status', $order->order_number) }}"
                                            name="form-order-status" method="post" class="btn">
                                            @csrf
                                            <input type="text" value="Ready for Pick Up" name="newOrderStatus"
                                                hidden>
                                            <button class="btn btn-success">Ready for Pick Up</button>
                                        </form>
                                    @else
                                        <form action="{{ route('order.update.status', $order->order_number) }}"
                                            name="form-order-status" method="post" class="btn">
                                            @csrf
                                            <input type="text" value="Ready To Ship" name="newOrderStatus" hidden>
                                            <button class="btn btn-success">Ready to Ship</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
