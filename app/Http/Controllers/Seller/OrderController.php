<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Events\OrderTrackingEvent;
use Illuminate\Database\Eloquent\Builder;
use App\Notifications\DeliveryNotification;


class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('getProductRelation', 'getCustomerRelation')->groupBy('order_number')->get();
        $newOrdersCount = Order::where('status', '=', 'Order Confirmed')->groupBy('order_number')->get()->count();
        $toPackCount = Order::where('status', '=', 'To Pack')->groupBy('order_number')->get()->count();
        $readyToShipCount = Order::where('status', '=', 'Ready To Ship')->groupBy('order_number')->get()->count();
        $shippingCount = Order::where('status', '=', 'Shipping')->groupBy('order_number')->get()->count();
        $readyForPickUpCount = Order::where('status', '=', 'Ready for Pick Up')->groupBy('order_number')->get()->count();


        $data = [
            "orders" => $orders,
            "newOrdersCount" => $newOrdersCount,
            "toPackCount" => $toPackCount,
            "readyToShipCount" => $readyToShipCount,
            "shippingCount" => $shippingCount,
            "readyForPickUpCount" => $readyForPickUpCount,

        ];

        return view('pages.seller.orders.index')->with($data);
    }

    public function show($order_number)
    {
        $orders = Order::where([['order_number', '=', $order_number]])->with('getUserRelation', 'getCustomerRelation', 'getProductRelation')->get();
        $data = [
            'orders' => $orders,
            'order_number' => $order_number
        ];
        return view('pages.seller.orders.show')->with($data);
    }

    public function toPrint($order_number)
    {
        $orders = Order::where([['order_number', '=', $order_number]])->with('getUserRelation', 'getCustomerRelation', 'getProductRelation')->get();

        $subtotal = 0;
        $shipping_fee = 50;
        foreach ($orders as $order) {
            $subtotal += $order->quantity * $order->getProductRelation->price;
        }

        $data = [
            'orders' => $orders,
            'order_number' => $order_number,
            'total_amount' => $subtotal + $shipping_fee
        ];
        return view('pages.seller.orders.print.pack')->with($data);
    }

    public function updateOrderStatus(Request $request, $order_number)
    {
        $newOrderStatus = $request->newOrderStatus;
        $status = "N/A";

        if ($newOrderStatus == "Cancel") {
            $updateOrderStatus = Order::where([['order_number', '=', $order_number]])->update(['status' => 'Cancelled']);
            $status = "Cancelled";
        } else if ($newOrderStatus == "To Pack") {
            $updateOrderStatus = Order::where([['order_number', '=', $order_number], ['status', '=', 'Order Confirmed']])->update(['status' => 'To Pack']);
            $status = "To Pack";
        } else if ($newOrderStatus == "Ready To Ship") {
            $updateOrderStatus = Order::where([['order_number', '=', $order_number], ['status', '=', 'To Pack']])->update(['status' => 'Ready To Ship']);
            $status = "Ready To Ship";
        } else if ($newOrderStatus == "Ready for Pick Up") {
            $updateOrderStatus = Order::where([['order_number', '=', $order_number], ['status', '=', 'To Pack']])->update(['status' => 'Ready for Pick Up']);
            $status = "Ready for Pick Up";
        } else if ($newOrderStatus == "Shipping") {
            $updateOrderStatus = Order::where([['order_number', '=', $order_number], ['status', '=', 'Ready To Ship']])->update(['status' => 'Shipping']);
            $status = "Shipping";
        } else if ($newOrderStatus == "Delivered") {
            $updateOrderStatus = Order::where([['order_number', '=', $order_number], ['status', '=', 'Shipping']])->update(['status' => 'Order Arrived']);
            $updatePaymentStatus = Payment::where("order_number", '=', $order_number)->update(['status' => 'Completed']);
            $status = "Order Arrived";
        } else if ($newOrderStatus == "Return") {
            $updateOrderStatus = Order::where([['order_number', '=', $order_number]])->update(['status' => 'Return']);
            $status = "Return";
        } else if ($newOrderStatus == "Refund") {
            $updateOrderStatus = Order::where([['order_number', '=', $order_number]])->update(['status' => 'Refund']);
            $status = "Refund";
        } else if ($newOrderStatus == "Failed Delivery") {
            $updateOrderStatus = Order::where([['order_number', '=', $order_number]])->update(['status' => 'Failed Delivery']);
            $updatePaymentStatus = Payment::where([["order_number", '=', $order_number], ['status', '!=', 'Completed']])->update(['status' => 'Failed']);
            $status = "Failed Delivery";
        }

        try {
            event(new OrderTrackingEvent($order_number, $status));
        } catch (\Throwable $th) {
            //throw $th;
        }
        return redirect(route('orders.show', $order_number));
    }

    public function scan_order()
    {
        return view('pages.seller.orders.scan');
    }

    public function updateScannedOrder(Request $request)
    {
        $newOrderStatus = $request->newOrderStatus;
        $order_number = $request->orderNumber;

        if ($newOrderStatus == "Successful Pick Up") {
            $updateOrderStatus = Order::where([['order_number', '=', $order_number], ['status', '=', 'Ready for Pick Up']])->update(['status' => 'Successful Pick Up']);
            $updatePaymentStatus = Payment::where("order_number", '=', $order_number)->update(['status' => 'Completed']);
        } else if ($newOrderStatus == "Failed Pick Up") {
            $updateOrderStatus = Order::where([['order_number', '=', $order_number], ['status', '=', 'Ready for Pick Up']])->update(['status' => 'Failed Pick Up']);
            $updatePaymentStatus = Payment::where([["order_number", '=', $order_number], ['status', '!=', 'Completed']])->update(['status' => 'Failed']);
        }

        return redirect(route('orders.show', $order_number));
    }

    public function checkOrderStatus($order_number)
    {
        $order = Order::where('order_number', $order_number)->first();
        $paymentStatus = $order->getPaymentRelation->status;
        $totalCost = $order->getPaymentRelation->total_cost;

        if (!$order) {
            return response()->json(['status' => 'Order not found'], 404);
        }

        // Check if the order is already picked up or completed
        if ($order->status === 'Successful Pick Up' || $order->status === 'Delivered') {
            return response()->json(['status' => 'Order is already picked up or completed'], 200);
        }

        return response()->json(['status' => 'Order is not picked up or completed', 'paymentStatus' => $paymentStatus, 'totalCost' => $totalCost], 200);
    }
}
