@extends('layouts.seller')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Sales Overview</h3>
                    <p class="text-subtitle text-muted">View daily sales overview. Compare today's performance with
                        yesterday's through informative graphs.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Sales</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Overview</li>
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
                    <div class="container">
                        <div class="card">
                            <div class="m-4">
                                <label for="dateFilter" class="form-label">Select Date Range:</label>
                                <div class="input-group">
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#dateRangeOptions" aria-expanded="false"
                                        aria-controls="dateRangeOptions">
                                        Select Range
                                    </button>
                                    <div class="collapse" id="dateRangeOptions">
                                        <div class="card card-body">
                                            <select id="dateFilter" class="form-select">
                                                <option value="today">Today
                                                    ({{ \Carbon\Carbon::today()->format('M j, Y') }})</option>
                                                <option value="yesterday">Yesterday
                                                    ({{ \Carbon\Carbon::yesterday()->format('M j, Y') }})</option>
                                                <option value="last7">Last 7 Days
                                                    ({{ \Carbon\Carbon::now()->subDays(7)->format('M j, Y') }} to
                                                    {{ \Carbon\Carbon::yesterday()->format('M j, Y') }})</option>
                                                <option value="last30">Last 30 Days
                                                    ({{ \Carbon\Carbon::now()->subDays(30)->format('M j, Y') }} to
                                                    {{ \Carbon\Carbon::yesterday()->format('M j, Y') }})</option>
                                                <option value="custom">Custom Date Range</option>
                                            </select>

                                            <div id="customDateRange" class="mt-2">
                                                <label for="customDateRangePicker" class="form-label">Custom Date
                                                    Range:</label>
                                                <input type="text" id="customDateRangePicker"
                                                    class="form-control datepicker" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="container mt-4">
                        <div class="row">
                            <div class="col-md-4 toggle-checkbox-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title text-muted">Revenue</h5>
                                        <label class="form-check-label position-absolute top-0 end-0">
                                            <input type="checkbox" class="form-check-input metric-checkbox" checked>
                                        </label>
                                        <h3 class="card-text">PHP <span id="card-revenue-value">0.00</span></h3>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 toggle-checkbox-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title text-muted">Visitors</h5>
                                        <label class="form-check-label position-absolute top-0 end-0">
                                            <input type="checkbox" class="form-check-input metric-checkbox" checked>
                                        </label>
                                        <h3 class="card-text"><span id="card-visitors-value">0</span></h3>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title text-muted">Conversion Rate</h5>
                                        <h3 class="card-text"><span id="card-conversion-rate-value">0</span>%</h3>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 toggle-checkbox-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title text-muted">Buyers</h5>
                                        <label class="form-check-label position-absolute top-0 end-0">
                                            <input type="checkbox" class="form-check-input metric-checkbox" checked>
                                        </label>
                                        <h3 class="card-text"><span id="card-buyers-value">0</span></h3>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 toggle-checkbox-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title text-muted">Orders</h5>
                                        <label class="form-check-label position-absolute top-0 end-0">
                                            <input type="checkbox" class="form-check-input metric-checkbox" checked>
                                        </label>
                                        <h3 class="card-text"><span id="card-orders-value">0</span></h3>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 toggle-checkbox-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title text-muted">Average Basket Size</h5>
                                        <label class="form-check-label position-absolute top-0 end-0">
                                            <input type="checkbox" class="form-check-input metric-checkbox" checked>
                                        </label>
                                        <h3 class="card-text"><span id="card-average-basket-size-value">0</span></>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <a href="" id="current-date-link">
                                    <div class="card">
                                        <div class="card-title">
                                            <center>
                                                <h5 class="card-title m-4"><span id="current-date-title">Today Sales
                                                    </span> <span class="text-muted"
                                                        id="current-date-range">({{ \Carbon\Carbon::today()->format('M j, Y') }})</span>
                                                </h5>
                                            </center>
                                        </div>
                                    </div>
                                </a>
                            </div>

                        </div>
                    </div>
                    <div class="container">
                        <div class="card">
                            <div id="lineChart" class="mt-4"></div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@endsection

@section('scripts')
    {{-- Sales Chart Script  --}}
    <script>
        $(document).ready(function() {
            // Sample data
            var metricsData = {
                revenue: [0, 0, 0, 0, 0, 0, 0],
                visitors: [0, 0, 0, 0, 0, 0, 0],
                buyers: [0, 0, 0, 0, 0, 0, 0],
                orders: [0, 0, 0, 0, 0, 0, 0],
                average_basket_size: [0, 0, 0, 0, 0, 0, 0]
            };

            var options = {
                chart: {
                    height: 350,
                    type: 'area',
                    stacked: false
                },
                dataLabels: {
                    enabled: false
                },
                series: [{
                        name: 'Revenue',
                        data: [200, 300, 250, 400, 350]
                    },
                    {
                        name: 'Visitors',
                        data: [100, 150, 120, 180, 160]
                    },
                    {
                        name: 'Buyers',
                        data: [30, 40, 35, 45, 42]
                    },
                    {
                        name: 'Orders',
                        data: [25, 35, 30, 40, 38]
                    },
                    {
                        name: 'Average Basket Size',
                        data: [2, 3, 2, 3, 2]
                    }
                ],
                stroke: {
                    width: [2, 2, 2, 2, 2, 2],
                    curve: 'smooth'
                },
                xaxis: {
                    categories: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Day 7'],
                },
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'left',
                    onItemClick: {
                        toggleDataSeries: true
                    },
                },
                markers: {
                    size: 5,
                    colors: ['#FFA41B'],
                    strokeColors: '#fff',
                    strokeWidth: 2,
                    hover: {
                        size: 7,
                    }
                }
            };

            // Initialize chart
            var chart = new ApexCharts(document.querySelector("#lineChart"), options);
            chart.render();

            // Checkbox change event for all checkboxes with class 'metric-checkbox'
            $('.metric-checkbox').change(function() {
                updateChart(getSelectedMetrics());
            });

            $('.toggle-checkbox-card').hover(function() {
                $(this).parent().css('cursor', 'pointer');
            }, function() {
                $(this).parent().css('cursor', 'default');
            }).click(function() {
                var checkbox = $(this).find('.metric-checkbox');
                checkbox.prop('checked', !checkbox.prop('checked'));
                updateChart(getSelectedMetrics());
            });

            // Function to update chart based on selected metrics
            function updateChart(selectedMetrics) {
                var series = selectedMetrics.map(metric => ({
                    name: metric,
                    data: metricsData[metric.replace(/\s+/g, '_')]
                }));
                chart.updateSeries(series);
            }

            // Function to get selected metrics based on checkbox state
            function getSelectedMetrics() {
                var selectedMetrics = [];
                $('.metric-checkbox:checked').each(function() {
                    var metric = $(this).closest('.card').find('.card-title').text().trim();
                    selectedMetrics.push(metric.toLowerCase());
                });
                return selectedMetrics;
            }

            // Initial chart update with default selected metrics
            updateChart(getSelectedMetrics());

            $('#customDateRange').hide();

            // Function to update data based on selected date
            function updateData(startDate, endDate, csrfToken) {
                // AJAX request
                $.ajax({
                    url: '{{ route('sales.data') }}',
                    method: 'POST',

                    data: {
                        _token: csrfToken,
                        startDate: startDate,
                        endDate: endDate,
                        // Add any other data you need to send
                    },
                    success: function(response) {
                        var dateParam = response.dateParam;
                        var currentUrl = "{{ route('sales.history') }}";
                        var startDate = dateParam[0];
                        var endDate = dateParam[dateParam.length - 1];
                        var newUrl = currentUrl + "?start_date=" + startDate + "&end_date=" + endDate;

                        // Set the new URL as the href attribute
                        $("#current-date-link").attr("href", newUrl);

                        // Update your UI with the fetched data
                        $('#card-revenue-value').text(
                            response.revenue
                            .map(value => parseFloat(value))
                            .reduce((accumulator, currentValue) => accumulator + currentValue, 0)
                            .toFixed(2)
                        );
                        $('#card-visitors-value').text(response.visitors.reduce((accumulator,
                            currentValue) => accumulator + parseInt(currentValue), 0));
                        $('#card-conversion-rate-value').text(response.conversion_rate);
                        $('#card-buyers-value').text(response.buyers.reduce((accumulator,
                            currentValue) => accumulator + currentValue, 0));
                        $('#card-orders-value').text(response.orders.reduce((accumulator,
                            currentValue) => accumulator + currentValue, 0));
                        // Filter out non-numeric values and sum the array
                        const basketSizeSum = response.average_basket_size
                            .filter(value => !isNaN(value))
                            .reduce((accumulator, currentValue) => accumulator + parseFloat(
                                currentValue), 0);

                        // Round down the sum to the nearest whole number
                        $('#card-average-basket-size-value').text(Math.floor(basketSizeSum));



                        metricsData.revenue = response.revenue;
                        metricsData.visitors = response.visitors;
                        metricsData.buyers = response.buyers;
                        metricsData.orders = response.orders;
                        metricsData.average_basket_size = response.average_basket_size;

                        // Assuming your response structure matches the metricsData format
                        var series = getSelectedMetrics().map(metric => ({
                            name: metric,
                            data: response[metric.replace(/\s+/g, '_')]
                        }));

                        // Update the chart series and x-axis categories
                        chart.updateOptions({
                            series: series,
                            xaxis: {
                                categories: response.dateRange
                            }
                        });

                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    }
                });
            }

            // Initialize flatpickr for date range selection
            flatpickr('#customDateRangePicker', {
                mode: 'range',
                dateFormat: 'M j, Y',
                onClose: function(selectedDates, dateStr, instance) {
                    // Additional logic after date selection if needed
                    var csrfToken = '{{ csrf_token() }}';
                    var formattedStartDate = selectedDates[0].toLocaleDateString('en-CA');
                    var formattedEndDate = selectedDates[1].toLocaleDateString('en-CA');

                    $('#current-date-title').text('Custom Date');
                    $('#current-date-range').text(`(${dateStr})`);
                    updateData(formattedStartDate, formattedEndDate, csrfToken);
                }
            });

            $('#dateFilter').change(function() {
                var csrfToken = '{{ csrf_token() }}';
                var selectedValue = $(this).val();

                if (selectedValue === 'custom') {
                    $('#customDateRange').show();
                    // Handle custom date range logic here if needed
                } else {
                    $('#customDateRange').hide();

                    // Set default start and end dates
                    var startDate, endDate;

                    if (selectedValue === "today") {
                        startDate = endDate = '{{ \Carbon\Carbon::today()->format('Y-m-d') }}';
                        $('#current-date-title').text('Today Sales');
                        $('#current-date-range').text(`({{ \Carbon\Carbon::today()->format('M d') }})`);
                    } else if (selectedValue === "yesterday") {
                        startDate = endDate = '{{ \Carbon\Carbon::yesterday()->format('Y-m-d') }}';
                        $('#current-date-title').text('Yesterday Sales');
                        $('#current-date-range').text(
                            `({{ \Carbon\Carbon::yesterday()->format('M d') }})`);
                    } else if (selectedValue === "last7") {
                        startDate = '{{ \Carbon\Carbon::now()->subDays(7)->format('Y-m-d') }}';
                        endDate = '{{ \Carbon\Carbon::yesterday()->format('Y-m-d') }}';
                        $('#current-date-title').text('Last 7 Days Sales');
                        $('#current-date-range').text(
                            `({{ \Carbon\Carbon::now()->subDays(7)->format('M d') }} to {{ \Carbon\Carbon::yesterday()->format('M d') }})`
                        );
                    } else if (selectedValue === "last30") {
                        startDate = '{{ \Carbon\Carbon::now()->subDays(30)->format('Y-m-d') }}';
                        endDate = '{{ \Carbon\Carbon::yesterday()->format('Y-m-d') }}';
                        $('#current-date-title').text('Last 30 Days Sales');
                        $('#current-date-range').text(
                            `({{ \Carbon\Carbon::now()->subDays(30)->format('M d') }} to {{ \Carbon\Carbon::yesterday()->format('M d') }})`
                        );
                    }

                    // Update data based on the selected date range
                    updateData(startDate, endDate, csrfToken);
                }
            });

            $('#dateFilter').val('today').trigger('change');


        });
    </script>
@endsection
