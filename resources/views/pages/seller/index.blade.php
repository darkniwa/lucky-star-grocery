@extends('layouts.seller')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Seller Dashboard</h3>
                    <p class="text-subtitle text-muted">Manage your seller account and track sales effortlessly.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Seller Dashboard</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-9">
                <div class="row">
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon purple">
                                            <i class="bi bi-cart-check-fill"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">New<br>Orders</h6>
                                        <h6 class="font-extrabold mb-0">{{ $confirmedOrders }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon blue">
                                            <i class="bi bi-card-list"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Processing Orders</h6>
                                        <h6 class="font-extrabold mb-0">{{ $processingOrders }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon green">
                                            <i class="bi bi-truck"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Ready<br>To Ship</h6>
                                        <h6 class="font-extrabold mb-0">{{ $readyToShip }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon red">
                                            <i class="bi bi-box-seam"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Item for<br>Pick up</h6>
                                        <h6 class="font-extrabold mb-0">{{ $readyForPickUp }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-3">
                <div class="card">
                    <div class="card-body py-4 px-5">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-xl">

                                <img src="{{ Auth::user()->getCustomerRelation->picture ?? asset('assets/seller/images/default-avatar.jpg') }}"
                                    alt="Profile">
                            </div>
                            <div class="ms-3 name">
                                <h5 class="font-bold">{{ Auth::user()->display_name }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-9">
                <div class="card">
                    <div class="card-header">
                        <h4>Yearly Sales Overview</h4>
                    </div>
                    <div class="card-body">
                        <div id="monthly-sales-chart"></div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-3">
                <div class="row" id="table-borderless">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Recent Orders</h4>
                        </div>
                        <div class="card-content">
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recentCustomer as $key => $order)
                                            <tr>
                                                <td class="text-bold-500">{{ $key + 1 }}</td>
                                                <td class="text-bold-500">
                                                    {{ $order->getCustomerRelation->first_name . ' ' . $order->getCustomerRelation->last_name }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.42.0/apexcharts.min.css"
        integrity="sha512-nnNXPeQKvNOEUd+TrFbofWwHT0ezcZiFU5E/Lv2+JlZCQwQ/ACM33FxPoQ6ZEFNnERrTho8lF0MCEH9DBZ/wWw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.42.0/apexcharts.min.js"
        integrity="sha512-HctQcT5hnI/elQck4950pvd50RuDnjCSGSoHI8CNyQIYVxsUoyJ+gSQIOrll4oM/Z7Kfi7WCLMIbJbiwYHFCpA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Sample data
            const monthlySalesData = {!! $monthlySalesJSON !!};
            const monthlyVisitorsData = {!! $monthlyVisitorsJSON !!};
            console.log(monthlySalesData);

            // Get the current month and year
            const currentMonth = (new Date()).getMonth() + 1; // JavaScript months are zero-indexed
            const currentYear = (new Date()).getFullYear();

            // Generate the preview month names
            const monthNames = Array.from({
                length: 12
            }, (_, index) => {
                const month = (currentMonth - index) % 12;
                const formattedMonth = month === 0 ? 12 : month; // Adjust zero to December
                return new Date(currentYear, formattedMonth - 1, 1).toLocaleString('en-US', {
                    month: 'short'
                });
            }).reverse();

            // Fill in missing months with zero sales using a more flexible matching
            const filledSalesData = monthNames.map((month) => {
                const regex = new RegExp(month, 'i'); // Case-insensitive matching
                const salesItem = monthlySalesData.find(item => regex.test(item.month));
                return {
                    month,
                    sales: salesItem ? salesItem.sales : 0,
                };
            });

            // Fill in missing months with zero visitors
            const filledVisitorsData = monthNames.map((month) => {
                const regex = new RegExp(month, 'i'); // Case-insensitive matching
                const visitorsItem = monthlyVisitorsData.find(item => regex.test(item.month));
                return {
                    month,
                    visitors: visitorsItem ? visitorsItem.visitors : 0,
                };
            });

            // ApexCharts initialization
            var options = {
                chart: {
                    type: 'bar',
                },
                series: [{
                        name: 'Revenue',
                        data: filledSalesData.map((item) => item.sales),
                    },
                    {
                        name: 'Visitors',
                        data: filledVisitorsData.map((item) => item.visitors),
                    }
                ],
                xaxis: {
                    categories: filledSalesData.map((item) => item.month),
                },
            };

            var chart = new ApexCharts(document.querySelector('#monthly-sales-chart'), options);
            chart.render();
        });
    </script>
@endsection
