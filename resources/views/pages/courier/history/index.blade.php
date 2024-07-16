@extends('layouts.courier')
@section('content')
              
<div class="page-heading">
    <h3>History</h3>
</div>
<div class="page-content">
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h6>Recent Transactions</h6>
            </div>
            <div class="card-body">
                <table class="table" id="table1">
                    <thead>
                        <tr>
                            <th>Order Number</th>
                            <th>Mode of Payment</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($deliveries as $delivery)
                            <tr>
                                <td>{{$delivery->order_number}}</td>
                                <td>{{$delivery->getOrderRelation->mode_of_payment}}</td>
                                <td>@datetime($delivery->getOrderRelation->updated_at)</td>
                                <td>{{$delivery->getOrderRelation->status}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>
@endsection

