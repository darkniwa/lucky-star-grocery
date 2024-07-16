<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Payment;
use Carbon\Carbon;

class PageController extends Controller
{
    public function index(){
        $total_customers = User::join('roles', 'users.id', '=', 'roles.user_id')
        ->where('role', 'customer')
        ->get()
        ->count();

        $total_employees = User::join('roles', 'users.id', '=', 'roles.user_id')
        ->whereIn('role', ['owner', 'manager', 'courier', 'cashier'])
        ->get()
        ->count();

        $total_orders = Order::where('order_number', '!=', null)
        ->groupBy('order_number')
        ->get()
        ->count();
        
        $monthly_revenue = Payment::whereMonth('updated_at', Carbon::now()->month)
        ->get()
        ->sum('total_cost');

        $data = [
            'total_customers' => $total_customers,
            'total_employees' => $total_employees,
            'total_orders' => $total_orders,
            'monthly_revenue' => $monthly_revenue
        ];

        return view('pages.owner.index')->with($data);
    }
}
