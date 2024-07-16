<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Payment;
use Carbon\Carbon;
use App\Models\Visitor;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function index()
    {
        $confirmedOrders = $this->getOrderCountByStatus('Order Confirmed');
        $processingOrders = $this->getOrderCountByStatus('To Pack');
        $readyToShip = $this->getOrderCountByStatus('Ready To Ship');
        $readyForPickUp = $this->getOrderCountByStatus('Ready for Pick Up');
        $genderMale = $this->getCustomerCountByGender('Male');
        $genderFemale = $this->getCustomerCountByGender('Female');
        $genderNA = $this->getCustomerCountByGender(['Prefer not to say', null]);
        $recentCustomer = $this->getRecentCustomers(5);

        $monthlySalesJSON = $this->getMonthlySalesData();
        $monthlyVisitors = $this->getMonthlyVisitors();

        $data = [
            'confirmedOrders' => $confirmedOrders,
            'processingOrders' => $processingOrders,
            'readyToShip' => $readyToShip,
            'readyForPickUp' => $readyForPickUp,
            'genderMale' => $genderMale,
            'genderFemale' => $genderFemale,
            'genderNA' => $genderNA,
            'recentCustomer' => $recentCustomer,
            'monthlySalesJSON' => $monthlySalesJSON,
            'monthlyVisitorsJSON' => $monthlyVisitors,
        ];

        return view('pages.seller.index')->with($data);
    }

    private function getOrderCountByStatus($status)
    {
        return Order::where('status', $status)->count();
    }

    private function getCustomerCountByGender($gender)
    {
        return Customer::whereIn('gender', (array) $gender)->count();
    }

    private function getRecentCustomers($limit)
    {
        return Order::where('status', 'Delivered')
            ->orderBy('id', 'desc')
            ->with('getCustomerRelation')
            ->groupBy('order_number')
            ->take($limit)
            ->get();
    }

    private function getMonthlySalesData()
    {
        $monthlySalesData = Payment::selectRaw('MONTH(created_at) as month, SUM(total_cost) as sales')
            ->where('status', 'Completed')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $formattedSalesData = [];

        foreach ($monthlySalesData as $data) {
            $formattedSalesData[] = [
                'month' => Carbon::create()->month($data->month)->format('F'),
                'sales' => $data->sales,
            ];
        }

        return json_encode($formattedSalesData);
    }

    private function getMonthlyVisitors()
    {
        $dailyVisitorsData = Visitor::select(DB::raw('DATE(visit_date) as day'), DB::raw('COUNT(DISTINCT ip_address) as visitors'))
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $monthlyVisitorsData = [];

        foreach ($dailyVisitorsData as $data) {
            $formattedDate = Carbon::parse($data->day);
            $monthYearKey = $formattedDate->format('F Y');

            if (!isset($monthlyVisitorsData[$monthYearKey])) {
                $monthlyVisitorsData[$monthYearKey] = [
                    'month' => $formattedDate->format('F'),
                    'year' => $formattedDate->format('Y'),
                    'visitors' => 0,
                ];
            }

            $monthlyVisitorsData[$monthYearKey]['visitors'] += $data->visitors;
        }

        return json_encode(array_values($monthlyVisitorsData));
    }

    public function login()
    {
        return view('pages.seller.auth.login');
    }
}
