<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Events\OrderTrackingEvent;
use App\Models\Remittance;

class DeliveryController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;

        $deliveries = Delivery::where('courier_id', '=', $id)->get();
        $orders = Order::where('status', '=', 'Ready To Ship')->groupBy('order_number')->get();
        $data = [
            'deliveries' => $deliveries,
            'orders' => $orders,
        ];
        return view('pages.seller.delivery.index')->with($data);
    }

    public function show($order_number)
    {
        $orders = Order::where([['order_number', '=', $order_number]])->with('getUserRelation', 'getCustomerRelation', 'getProductRelation')->get();
        $data = [
            'orders' => $orders,
            'order_number' => $order_number
        ];

        return view('pages.seller.delivery.show')->with($data);
    }

    public function checkOrderNumber(Request $_request)
    {
        $order = Order::where('order_number', '=', $_request->input('OrderNumber'))->first();
        if ($order == null) {
            return redirect()->back()->with('error', "Order not found");
        } else {
            return redirect(route('delivery.show', $order->order_number));
        }
    }

    public function updateStatus(Request $request, $order_number)
    {
        $newOrderStatus = $request->newOrderStatus;
        $status = "N/A";

        if ($newOrderStatus == "Shipping") {
            $updateOrderStatus = Order::where([['order_number', '=', $order_number], ['status', '=', 'Ready To Ship']])->update(['status' => 'Shipping']);
            $assignCourier = new Delivery;
            $assignCourier->order_number = $order_number;
            $assignCourier->courier_id = Auth::user()->id;
            $assignCourier->save();
            $status = "Shipping";
        } else if ($newOrderStatus == "Delivered") {
            $updateOrderStatus = Order::where([['order_number', '=', $order_number], ['status', '=', 'Shipping']])->update(['status' => 'Order Arrived']);
            $updatePaymentStatus = Payment::where("order_number", '=', $order_number)->update(['status' => 'Completed']);

            $order = Order::where('order_number', '=', $order_number)->first();
            $newTransaction = new Transaction;
            $newTransaction->delivery_id = $order->getDeliveryRelation->id;
            $newTransaction->sender_id = $order->user_id;
            $newTransaction->type = "Collection";
            $newTransaction->receiver_id = Auth::user()->id;
            $newTransaction->amount_received = $order->getPaymentRelation->total_cost + $order->getPaymentRelation->shipping_fee;
            $newTransaction->save();

            if ($order->mode_of_payment == "cod") {
                $remittance = Remittance::where("order_number", "=", $order_number)->first();
                $remittance->collector_id = Auth::user()->id;
                $remittance->status = "Collected";
                $remittance->save();
            }
            // Find the user's wallet
            $wallet = Wallet::where('user_id', '=', Auth::user()->id)->first();

            // Check if the wallet exists
            if (!$wallet) {
                // If the wallet doesn't exist, create a new one with an initial balance of 0
                $wallet = new Wallet();
                $wallet->user_id = Auth::user()->id;
                $wallet->account_balance = 0;
                $wallet->save();
            }

            // Update the account balance by subtracting the amount_received
            $wallet->account_balance = $wallet->account_balance - $newTransaction->amount_received;
            $wallet->save();

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

        return redirect(route('delivery.show', $order_number));
    }
}
