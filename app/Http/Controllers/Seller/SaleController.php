<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Payment;
use Carbon\Carbon;
use App\Models\Order;
use App\Exports\SalesExport;

class SaleController extends Controller
{
    public function sales_report()
    {
        $todayIncome = Payment::where('status', '=', 'Completed')->whereDate('updated_at', Carbon::today())->get();
        $yesterdayIncome = Payment::where('status', '=', 'Completed')->whereDate('updated_at', Carbon::yesterday())->get();

        $todayIncomeArray = [0, 0, 0, 0, 0, 0, 0, 0];
        $yesterdayIncomeArray = [0, 0, 0, 0, 0, 0, 0, 0];

        foreach ($todayIncome as $value) {
            if ($value->updated_at->gt(Carbon::today()) && $value->updated_at->lt(Carbon::today()->addHours(3))) {
                $todayIncomeArray[0] += $value->total_cost;
            } else if ($value->updated_at->gt(Carbon::today()->addHours(3)) && $value->updated_at->lt(Carbon::today()->addHours(6))) {
                $todayIncomeArray[1] += $value->total_cost;
            } else if ($value->updated_at->gt(Carbon::today()->addHours(6)) && $value->updated_at->lt(Carbon::today()->addHours(9))) {
                $todayIncomeArray[2] += $value->total_cost;
            } else if ($value->updated_at->gt(Carbon::today()->addHours(9)) && $value->updated_at->lt(Carbon::today()->addHours(12))) {
                $todayIncomeArray[3] += $value->total_cost;
            } else if ($value->updated_at->gt(Carbon::today()->addHours(12)) && $value->updated_at->lt(Carbon::today()->addHours(15))) {
                $todayIncomeArray[4] += $value->total_cost;
            } else if ($value->updated_at->gt(Carbon::today()->addHours(15)) && $value->updated_at->lt(Carbon::today()->addHours(18))) {
                $todayIncomeArray[5] += $value->total_cost;
            } else if ($value->updated_at->gt(Carbon::today()->addHours(18)) && $value->updated_at->lt(Carbon::today()->addHours(21))) {
                $todayIncomeArray[6] += $value->total_cost;
            } else if ($value->updated_at->gt(Carbon::today()->addHours(21)) && $value->updated_at->lt(Carbon::today()->addHours(24))) {
                $todayIncomeArray[7] += $value->total_cost;
            }
        }

        foreach ($yesterdayIncome as $value) {
            if ($value->updated_at->gt(Carbon::yesterday()) && $value->updated_at->lt(Carbon::yesterday()->addHours(3))) {
                $yesterdayIncomeArray[0] += $value->total_cost;
            } else if ($value->updated_at->gt(Carbon::yesterday()->addHours(3)) && $value->updated_at->lt(Carbon::yesterday()->addHours(6))) {
                $yesterdayIncomeArray[1] += $value->total_cost;
            } else if ($value->updated_at->gt(Carbon::yesterday()->addHours(6)) && $value->updated_at->lt(Carbon::yesterday()->addHours(9))) {
                $yesterdayIncomeArray[2] += $value->total_cost;
            } else if ($value->updated_at->gt(Carbon::yesterday()->addHours(9)) && $value->updated_at->lt(Carbon::yesterday()->addHours(12))) {
                $yesterdayIncomeArray[3] += $value->total_cost;
            } else if ($value->updated_at->gt(Carbon::yesterday()->addHours(12)) && $value->updated_at->lt(Carbon::yesterday()->addHours(15))) {
                $yesterdayIncomeArray[4] += $value->total_cost;
            } else if ($value->updated_at->gt(Carbon::yesterday()->addHours(15)) && $value->updated_at->lt(Carbon::yesterday()->addHours(18))) {
                $yesterdayIncomeArray[5] += $value->total_cost;
            } else if ($value->updated_at->gt(Carbon::yesterday()->addHours(18)) && $value->updated_at->lt(Carbon::yesterday()->addHours(21))) {
                $yesterdayIncomeArray[6] += $value->total_cost;
            } else if ($value->updated_at->gt(Carbon::yesterday()->addHours(21)) && $value->updated_at->lt(Carbon::yesterday()->addHours(24))) {
                $yesterdayIncomeArray[7] += $value->total_cost;
            }
        }

        for ($i = 1; $i < 8; $i++) {
            $todayIncomeArray[$i] += $todayIncomeArray[$i - 1];
            $yesterdayIncomeArray[$i] += $yesterdayIncomeArray[$i - 1];
        }

        $data = ["todayIncomeArray" => $todayIncomeArray, "yesterdayIncomeArray" => $yesterdayIncomeArray];

        return view('pages.seller.sales.index')->with($data);
    }

    public function salesOverview()
    {
        $data = [];
        return view('pages.seller.sales.overview')->with($data);
    }

    public function salesHistory(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Validate and set default dates if not provided
        $startDate = $startDate ? Carbon::parse($startDate)->startOfDay() : Carbon::now()->subYear();
        $endDate = $endDate ? Carbon::parse($endDate)->endOfDay() : Carbon::now();

        // Fetch orders based on the date range and specific statuses
        $orders = Order::whereBetween('created_at', [$startDate, $endDate])
            ->whereIn('status', ['Delivered', 'Order Arrived', 'Successful Pick Up'])
            ->select(
                'order_number',
                DB::raw('SUM(quantity) as total_quantity'),
                'user_id',
                'created_at'
            )
            ->groupBy('order_number', 'user_id', 'created_at')
            ->get();

        $data = [
            'startDate' => $startDate->format('Y-m-d'),
            'endDate' => $endDate->format('Y-m-d'),
            'orders' => $orders,
        ];

        return view('pages.seller.sales.history')->with($data);
    }

    public function exportSales(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Validate and set default dates if not provided
        $startDate = $startDate ? Carbon::parse($startDate)->startOfDay() : Carbon::now()->startOfMonth();
        $endDate = $endDate ? Carbon::parse($endDate)->endOfDay() : Carbon::now()->endOfMonth();

        // Fetch sales based on the date range and specific statuses
        $sales = Order::whereBetween('created_at', [$startDate, $endDate])
            ->whereIn('status', ['Delivered', 'Order Arrived', 'Successful Pick Up'])
            ->get();

        // Export the data as CSV
        $export = new SalesExport($sales);
        return $export->export();
    }

    public function productsAndPerformance()
    {
        $data = [];
        return view('pages.seller.sales.products_and_performance')->with($data);
    }


    public function getSalesData(Request $request)
    {
        $startDate = Carbon::parse($request->input('startDate'))->startOfDay();
        $endDate = Carbon::parse($request->input('endDate'))->endOfDay();

        $dateRange = $this->getDateRange($startDate, $endDate);
        $humanReadableDateRange = $this->formatDateRange($dateRange, $startDate);

        $revenueData = $this->getRevenueData($startDate, $endDate);
        $buyersData = $this->getBuyersData($startDate, $endDate);
        $visitorsData = $this->getDailyVisitorsData($startDate, $endDate);
        $ordersData = $this->getOrdersData($startDate, $endDate);
        $averageBasketSizeData = $this->getAverageBasketSizeData($startDate, $endDate);

        // Other sales data fetching logic can be added here...

        if ($startDate->isSameDay($endDate)) {
            list($revenue, $visitors, $buyers, $orders, $average_basket_size) = $this->processHourlyData($dateRange, $revenueData, $buyersData, $visitorsData, $ordersData, $averageBasketSizeData, $startDate);
        } else {
            list($revenue, $visitors, $buyers, $orders, $average_basket_size) = $this->processDailyData($dateRange, $revenueData, $buyersData, $visitorsData, $ordersData, $averageBasketSizeData);
        }

        $conversion_rate = $this->calculateConversionRate($buyers, $visitors);

        $response = [
            'dateParam' => $dateRange,
            'dateRange' => $humanReadableDateRange,
            'revenue' => $revenue,
            'visitors' => $visitors,
            'conversion_rate' => $this->calculateConversionRate($buyers, $visitors),
            'buyers' => $buyers,
            'orders' => $orders,
            'average_basket_size' => $average_basket_size,
        ];

        return response()->json($response);
    }

    private function getRevenueData($startDate, $endDate)
    {
        // If start and end dates are the same, fetch data by hour
        if ($startDate->isSameDay($endDate)) {
            //     // Generate an array of 24 hours for the given date
            $revenueData = Payment::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:00:00") as date'),
                DB::raw('COALESCE(SUM(total_cost), 0) as total_revenue')
            )
                ->whereBetween('created_at', [$startDate, $endDate])
                ->where('status', 'Completed')
                ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:00:00")'))
                ->get();
        } else {
            // Fetch revenue data for each date
            $revenueData = Payment::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_cost) as total_revenue'))
                ->whereBetween('created_at', [$startDate, $endDate])
                ->where('status', 'Completed')
                ->groupBy(DB::raw('DATE(created_at)'))
                ->get();
        }

        // Create an associative array with date as the key and total revenue as the value
        return $revenueData->pluck('total_revenue', 'date')->all();
    }

    private function getBuyersData($startDate, $endDate)
    {
        // If start and end dates are the same, fetch data by day
        if ($startDate->isSameDay($endDate)) {
            $buyersData = DB::table('orders')
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(DISTINCT user_id) as total_buyers'))
                ->whereBetween('created_at', [$startDate, $endDate])
                ->whereIn('status', ['Delivered', 'Order Arrived'])
                ->groupBy(DB::raw('DATE(created_at)'))
                ->get();
        } else {
            // Fetch buyers data for each date
            $buyersData = DB::table('orders')
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(DISTINCT user_id) as total_buyers'))
                ->whereBetween('created_at', [$startDate, $endDate])
                ->whereIn('status', ['Delivered', 'Order Arrived'])
                ->groupBy(DB::raw('DATE(created_at)'))
                ->get();
        }

        // Create an associative array with date as the key and total buyers as the value
        return $buyersData->pluck('total_buyers', 'date')->all();
    }

    private function getDailyVisitorsData($startDate, $endDate)
    {
        // If start and end dates are the same, fetch data by hour
        if ($startDate->isSameDay($endDate)) {
            $visitorsData = DB::table('visitors')
                ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:00:00") as date'), DB::raw('COUNT(DISTINCT ip_address) as total_visitors'))
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:00:00")'))
                ->get();
        } else {
            // Fetch visitors data for each date
            $visitorsData = DB::table('visitors')
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(DISTINCT ip_address) as total_visitors'))
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy(DB::raw('DATE(created_at)'))
                ->get();
        }

        // Create an associative array with date as the key and total visitors as the value
        return $visitorsData->pluck('total_visitors', 'date')->all();
    }

    private function getOrdersData($startDate, $endDate)
    {
        // If start and end dates are the same, fetch data by hour
        if ($startDate->isSameDay($endDate)) {
            $ordersData = DB::table('orders')
                ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:00:00") as date'), DB::raw('COUNT(DISTINCT order_number) as total_orders'))
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:00:00")'))
                ->get();
        } else {
            // Fetch orders data for each date
            $ordersData = DB::table('orders')
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(DISTINCT order_number) as total_orders'))
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy(DB::raw('DATE(created_at)'))
                ->get();
        }

        // Create an associative array with date as the key and total orders as the value
        return $ordersData->pluck('total_orders', 'date')->all();
    }

    private function getAverageBasketSizeData($startDate, $endDate)
    {
        // If start and end dates are the same, fetch data by hour
        if ($startDate->isSameDay($endDate)) {
            $averageBasketSizeData = DB::table('orders')
                ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:00:00") as date'), DB::raw('AVG(quantity) as average_basket_size'))
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:00:00")'))
                ->get();
        } else {
            // Fetch average basket size data for each date
            $averageBasketSizeData = DB::table('orders')
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('AVG(quantity) as average_basket_size'))
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy(DB::raw('DATE(created_at)'))
                ->get();
        }

        // Create an associative array with date as the key and average basket size as the value
        return $averageBasketSizeData->pluck('average_basket_size', 'date')->all();
    }

    private function calculateConversionRate($buyers, $visitors)
    {
        $totalVisitors = array_sum($visitors);
        $totalBuyers = array_sum($buyers);

        return ($totalBuyers > 0 && $totalVisitors > 0) ? ($totalBuyers / $totalVisitors) * 100 : 0;
    }

    private function processHourlyData($dateRange, $revenueData, $buyersData, $visitorsData, $ordersData, $averageBasketSizeData, $startDate)
    {
        $revenue = $this->processData($dateRange, $revenueData, $startDate, 'H:00:00');
        $buyers = $this->processData($dateRange, $buyersData, $startDate, 'H:00:00');
        $visitors = $this->processData($dateRange, $visitorsData, $startDate, 'H:00:00');
        $orders = $this->processData($dateRange, $ordersData, $startDate, 'H:00:00');
        $average_basket_size = $this->processData($dateRange, $averageBasketSizeData, $startDate, 'H:00:00');

        return [$revenue, $visitors, $buyers, $orders, $average_basket_size];
    }

    private function processDailyData($dateRange, $revenueData, $buyersData, $visitorsData, $ordersData, $averageBasketSizeData)
    {
        $revenue = $this->processData($dateRange, $revenueData);
        $buyers = $this->processData($dateRange, $buyersData);
        $visitors = $this->processData($dateRange, $visitorsData);
        $orders = $this->processData($dateRange, $ordersData);
        $average_basket_size = $this->processData($dateRange, $averageBasketSizeData);

        return [$revenue, $visitors, $buyers, $orders, $average_basket_size];
    }

    private function processData($dateRange, $data, $startDate = null, $format = null)
    {
        return array_map(function ($date) use ($data, $startDate, $format) {
            $dateWithFormat = $format ? Carbon::parse($date)->format("Y-m-d $format") : $date;
            return $data[$dateWithFormat] ?? 0;
        }, $dateRange);
    }

    private function getDateRange($startDate, $endDate)
    {
        $start = strtotime($startDate);
        $end = strtotime($endDate);

        $dateRange = [];

        if ($startDate->isSameDay($endDate)) {
            // If start and end dates are the same, generate hours
            for ($i = 0; $i < 24; $i++) {
                $dateRange[] = date('Y-m-d H:00:00', strtotime("+$i hours", $start));
            }
        } else {
            // If start and end dates are different, generate days
            while ($start <= $end) {
                $dateRange[] = date('Y-m-d', $start);
                $start = strtotime('+1 day', $start);
            }
        }

        return $dateRange;
    }

    private function formatDateRange($dateRange, $startDate)
    {
        $firstDate = Carbon::parse($dateRange[0]);
        $lastDate = Carbon::parse(end($dateRange));

        return array_map(fn ($date) => $firstDate->isSameDay($lastDate) ? Carbon::parse($date)->format('gA') : Carbon::parse($date)->format('M j'), $dateRange);
    }
}
