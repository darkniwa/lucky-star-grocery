@extends('layouts.seller')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Remittance Report</h3>
                    <p class="text-subtitle text-muted">View detailed reports on remittance transactions to track cash
                        collections
                        and financial transfers made by couriers.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Remittance</li>
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
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('remittance.export') }}" class="btn btn-info">Generate Report</a>
                                </div>
                                <div class="btn-group" role="group">
                                    <button id="filterPending" type="button"
                                        class="btn btn-outline-warning">Pending</button>
                                    <button id="filterCollected" type="button"
                                        class="btn btn-outline-info">Collected</button>
                                    <button id="filterRemitted" type="button"
                                        class="btn btn-outline-success">Remitted</button>
                                    <button id="filterCancelled" type="button"
                                        class="btn btn-outline-danger">Cancelled</button>
                                    <button id="resetFilter" type="button" class="btn btn-outline-secondary">Reset</button>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="card-body">
                            <table class="table-responsive" id="table-remittance-history">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Reference No</th>
                                        <th class="text-end">Amount</th>
                                        <th>Status</th>
                                        <th>Payer</th>
                                        <th>Collector</th>
                                        <th>Remittance Handler</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($remittances as $remittance)
                                        <tr onclick="window.location='{{ route('remittance.order.show', $remittance->order_number) }}';"
                                            style="cursor: pointer;">
                                            <td>{{ $remittance->reference_no }}</td>
                                            <td class="text-end">@currency($remittance->amount)</td>
                                            <td>
                                                @if ($remittance->status == 'Pending')
                                                    <span
                                                        class="badge bg-warning text-dark">{{ $remittance->status }}</span>
                                                @elseif ($remittance->status == 'Collected')
                                                    <span class="badge bg-info">{{ $remittance->status }}</span>
                                                @elseif ($remittance->status == 'Remitted')
                                                    <span class="badge bg-success">{{ $remittance->status }}</span>
                                                @elseif ($remittance->status == 'Cancelled')
                                                    <span class="badge bg-danger">{{ $remittance->status }}</span>
                                                @endif
                                            </td>
                                            <td class="text-capitalize">
                                                {{ $remittance->getPayerUserRelation->display_name ?? '' }}</td>
                                            <td class="text-capitalize">
                                                {{ $remittance->getCollectorUserRelation->display_name ?? '' }}</td>
                                            <td class="text-capitalize">
                                                {{ $remittance->getRemittanceHandlerUserRelation->display_name ?? '' }}</td>
                                            <td>
                                                {!! $remittance->created_at->format('M j, Y') !!} <br>
                                                <span class="text-muted">{!! $remittance->created_at->format('h:i A') !!}</span>
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


@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.css">
@endsection

@section('scripts')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            let jquery_datatable = $('#table-remittance-history').DataTable();

            // Add event listeners to the status filter buttons
            $("#filterPending").on("click", function() {
                filterByStatus("Pending");
            });

            $("#filterCollected").on("click", function() {
                filterByStatus("Collected");
            });

            $("#filterRemitted").on("click", function() {
                filterByStatus("Remitted");
            });

            $("#filterCancelled").on("click", function() {
                filterByStatus("Cancelled");
            });

            function filterByStatus(status) {
                // Use DataTables API to set the filter and redraw the table
                jquery_datatable.column(2).search(status).draw();
            }

            // Optional: Add a button to reset the filter
            $("#resetFilter").on("click", function() {
                // Use DataTables API to clear the filter and redraw the table
                jquery_datatable.column(2).search("").draw();
            });
        });
    </script>
@endsection
