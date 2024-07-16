@extends('layouts.seller')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Sales History</h3>
                    <p class="text-subtitle text-muted">View sales history.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Sales</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Sales History</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        <section class="section">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('sales.history') }}" method="get">
                        <div class="input-group mb-3">
                            <label for="start_date" class="form-label visually-hidden">Start Date:</label>
                            <input type="date" class="form-control" id="start_date" name="start_date"
                                value="{{ $startDate }}" placeholder="Start Date">

                            <label for="end_date" class="form-label visually-hidden">End Date:</label>
                            <input type="date" class="form-control" id="end_date" name="end_date"
                                value="{{ $endDate }}" placeholder="End Date">

                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </form>
                </div>

                <div class="col-md-12 mt-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-3">Sales History from
                                    {{ \Carbon\Carbon::parse($startDate)->format('M j, Y') }}
                                    to
                                    {{ \Carbon\Carbon::parse($endDate)->format('M j, Y') }}</h5>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('sales.export', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                                        class="btn btn-info">Generate Report</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <table class="table-responsive" id="sales-table">
                                <thead>
                                    <tr>
                                        <th>Order Number</th>
                                        <th>Customer Name</th>
                                        <th>Basket Size</th>
                                        <th>Total Amount</th>
                                        <th>Order Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $order->order_number }}</td>
                                            <td>{{ $order->getUserRelation->display_name }}</td>
                                            <td>{{ $order->total_quantity }}</td>
                                            <td>PHP
                                                {{ number_format($order->getPaymentRelation->total_cost, 2, '.', ',') }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($order->created_at)->format('M j, Y - h:m A') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable with Buttons extension
            $('#sales-table').DataTable();
        });
    </script>
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.css">
@endsection
