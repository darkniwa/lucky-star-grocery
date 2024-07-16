@extends('layouts.seller')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Sales Report</h3>
                    <p class="text-subtitle text-muted">View daily sales data, including visitor numbers, purchases, revenue,
                        and conversion rates. Compare today's performance with yesterday's through informative graphs.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Sales Report</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        <section class="section">
            <div class="row">

                <div class="col-12 col-lg-12">
                    <div class="row">
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Revenue</h6>
                                        <h6 class="font-extrabold mb-0">0</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">
                                    <div class="col-md-12">
                                        <h6 class="text-muted font-semibold">Visitors</h6>
                                        <h6 class="font-extrabold mb-0">0</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">
                                    <div class="col-md-12">
                                        <h6 class="text-muted font-semibold">Buyers</h6>
                                        <h6 class="font-extrabold mb-0">0</h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-3 py-4-5">
                                    <div class="col-md-12">
                                        <h6 class="text-muted font-semibold">Conversion Rate</h6>
                                        <h6 class="font-extrabold mb-0">0</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Today vs. Yesterday Sales</h4>
                        </div>
                        <div class="card-body">
                            <div id="daily_sales"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/seller/vendors/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/seller/vendors/dayjs/dayjs.min.js') }}"></script>
    <script src="{{ asset('assets/seller/vendors/apexcharts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/seller/js/pages/ui-apexchart.js') }}"></script>

    <script>
        $(document).ready(function() {
            var options = {
                series: [{
                    name: 'Today',
                    data: [
                        {{ $todayIncomeArray[0] }},
                        {{ $todayIncomeArray[1] }},
                        {{ $todayIncomeArray[2] }},
                        {{ $todayIncomeArray[3] }},
                        {{ $todayIncomeArray[4] }},
                        {{ $todayIncomeArray[5] }},
                        {{ $todayIncomeArray[6] }},
                        {{ $todayIncomeArray[7] }},
                    ]
                }, {
                    name: 'Yesterday',
                    color: '#ededed',
                    data: [
                        {{ $yesterdayIncomeArray[0] }},
                        {{ $yesterdayIncomeArray[1] }},
                        {{ $yesterdayIncomeArray[2] }},
                        {{ $yesterdayIncomeArray[3] }},
                        {{ $yesterdayIncomeArray[4] }},
                        {{ $yesterdayIncomeArray[5] }},
                        {{ $yesterdayIncomeArray[6] }},
                        {{ $yesterdayIncomeArray[7] }},
                    ]
                }],
                chart: {
                    height: 350,
                    type: 'area'
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                xaxis: {
                    type: 'text',
                    categories: ["12:00 AM", "3:00 AM", "6:00 AM", "9:00 AM", "12:00 PM", "3:00 PM", "6:00 PM",
                        "9:00 PM", "12:00 AM"
                    ]
                },
                tooltip: {
                    x: {
                        format: 'hh:mm TT'
                    },
                },
            };

            var chart = new ApexCharts(document.querySelector("#daily_sales"), options);
            chart.render();
        });
    </script>
@endsection
