<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Payment;
use Auth;
use Luigel\Paymongo\Facades\Paymongo;
use App\Models\Notification;
use App\Models\Remittance;
use App\Models\User;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private function checkLowStockProducts(Product $product)
    {
        $lowStockThreshold = 25;
        $usersWithPermission = User::permission('manage_products')->get();

        // Check if the selected product is low in stock
        if ($product && $product->availability > 0 && $product->availability <= $lowStockThreshold) {

            foreach ($usersWithPermission as $user) {
                $existingNotifications = Notification::where('user_id', $user->id)
                    ->where('product_id', $product->id)
                    ->whereNull('read_at')
                    ->count();

                if ($existingNotifications == 0) {
                    $notification = new Notification([
                        'user_id' => $user->id,
                        'product_id' => $product->id,
                        'seen' => false,
                        'id' => Str::uuid(), // Ensure id is set as a UUID
                    ]);

                    $notification->save();
                }
            }
        } else {
            // If stock is above the threshold, remove existing notifications
            foreach ($usersWithPermission as $user) {
                Notification::where('user_id', $user->id)
                    ->where('product_id', $product->id)
                    ->delete();
            }
        }
    }

    public function index()
    {
        $user_id = auth()->user()->id;
        $cart = Order::with('getProductRelation')->where([['user_id', '=', $user_id], ['status', '=', 'Cart']])->get();
        return view('pages.customer.cart')->with('cart', $cart);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product_id = $request->product_id;
        $quantity = $request->qty;
        $user_id = auth()->user()->id;

        // Get the product's maximum availability stock
        $maxAvailability = Product::find($product_id)->availability;

        // Check if adding the requested quantity would exceed the maximum availability
        if ($quantity > $maxAvailability) {
            return response()->json(['message' => 'You have reached the maximum available stock for this product.'], 400);
        }

        // Check if the product already exists in the cart
        $cartItem = Order::where('user_id', $user_id)
            ->where('product_id', $product_id)
            ->where('status', 'Cart')
            ->first();

        if ($cartItem) {
            // Update the quantity of the existing cart item
            $newQuantity = $cartItem->quantity + $quantity;
            if ($newQuantity > $maxAvailability) {
                return response()->json(['error' => true, 'message' => 'You have reached the maximum available stock for this product.']);
            }
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            // Create a new cart item if it doesn't exist
            Order::create([
                'user_id' => $user_id,
                'product_id' => $product_id,
                'quantity' => $quantity,
                'status' => 'Cart'
            ]);
        }

        return response()->json(['message' => 'Product added to cart successfully.']);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate
        $this->validate($request, ['quantity' => 'required']);

        // Update Cart Quantity
        $cart = Order::find($id);
        $cart->quantity = $request->quantity;
        $cart->save();

        return response()->json($cart);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cart = Order::where('id', $id)->delete();

        return response()->json($cart);
    }

    public function clear()
    {
        $user_id = auth()->user()->id;
        $cart = Order::where([['user_id', '=', $user_id], ['status', '=', 'Cart']])->delete();
        return redirect('/orders')->with('success', 'Successfully Clear the Cart');
    }

    public function checkout()
    {
        $user_id = auth()->user()->id;
        $cart = Order::with('getProductRelation')->where([['user_id', '=', $user_id], ['status', '=', 'Cart']])->get();
        $total_cost = 0;
        $shipping_fee = 0;
        foreach ($cart as $item) {
            $price = $item->getProductRelation->discounted_price ? $item->getProductRelation->discounted_price : $item->getProductRelation->price;
            $total_cost += $price * $item->quantity;
        }
        $shipping_fee = 0;
        if ($total_cost < 500) {
            return redirect('/orders');
        } else if ($total_cost >= 500 && $total_cost <= 2500) {
            $shipping_fee = 50;
        }
        $data = ['cart' => $cart, 'total_cost' => $total_cost, 'shipping_fee' => $shipping_fee];
        return view('pages.customer.checkout')->with($data);
    }

    public function checkout_confirm(Request $request)
    {
        // Validate the request
        $this->validate($request, [
            'mode_of_payment' => 'required'
        ]);

        $user = auth()->user();
        $unique_id = $user->id . time();

        // Check if the mode of payment is GCash
        if ($request->mode_of_payment === 'gcash') {
            // Get user's cart orders
            $user_orders = Order::where([
                ['user_id', '=', $user->id],
                ['status', '=', 'Cart']
            ])->get();

            // Calculate the total cost
            $total_cost = 0;
            foreach ($user_orders as $order) {
                $product = Product::find($order->product_id);
                $product->decrement('availability', $order->quantity);
                $updatedProduct = Product::find($order->product_id);
                $this->checkLowStockProducts($updatedProduct);

                // Use the discounted_price if it's not null; otherwise, use the regular price
                $priceToUse = $order->getProductRelation->discounted_price ?? $order->getProductRelation->price;

                $total_cost += $order->quantity * $priceToUse;
            }

            // Set the initial shipping fee to 50
            $shipping_fee = 50;

            // Check conditions to adjust the shipping fee
            if ($request->user_addresses_id === 'store_pickup' || $total_cost >= 2500) {
                // If store pickup or total cost is 2500 or more, set shipping fee to 0
                $shipping_fee = 0;
            }

            // Store the data you want to keep in session
            session(['order_details' => $request->all()]);

            // Create GCash payment source with the total cost
            $gcashSource = Paymongo::source()->create([
                'type' => 'gcash',
                'amount' => $total_cost + $shipping_fee, // Set the amount to the total cost
                'currency' => 'PHP',
                'redirect' => [
                    'success' => route('orders.payment.gcash.success'),
                    'failed' => route('orders.payment.gcash.failed')
                ]
            ]);

            $paymentUrl = $gcashSource->getAttributes()['redirect']['checkout_url'];

            return redirect($paymentUrl);
        } else {
            $orderDetails = $request->all();
            $orderDetails['paymentStatus'] = 'Pending';
            $response = $this->checkoutConfirm(Request::create('/orders/checkout/confirm', 'POST', $orderDetails));
            return $response;
        }
    }

    public function checkoutConfirm(Request $request)
    {
        $user = auth()->user();
        $unique_id = $user->id . time();

        // Get user's cart orders
        $user_orders = Order::where([
            ['user_id', '=', $user->id],
            ['status', '=', 'Cart']
        ])->get();

        // Decrement product availability for each order
        foreach ($user_orders as $order) {
            $product = Product::find($order->product_id);
            $product->decrement('availability', $order->quantity);
            $updatedProduct = Product::find($order->product_id);
            $this->checkLowStockProducts($updatedProduct);
        }

        $user_addresses_id = $request->input('user_addresses_id');

        // Handle "Pickup in Store" option
        if ($user_addresses_id === 'store_pickup') {
            $user_addresses_id = null;
        }

        // Update Order Status
        $orders = Order::where([
            ['user_id', '=', $user->id],
            ['status', '=', 'Cart']
        ])->update([
            'status' => 'Order Confirmed',
            'order_number' => $unique_id,
            'mode_of_payment' => $request->mode_of_payment,
            'user_addresses_id' => $user_addresses_id,
            'created_at' => now()
        ]);

        // Update or Create Payment Record
        $getOrder = Order::where('order_number', '=', $unique_id)->with('getProductRelation')->get();
        $total_cost = 0;
        $freeShippingThreshold = 2500;
        $shipping_fee = $total_cost >= $freeShippingThreshold ? 0 : 50;
        $mode_of_payment = $getOrder[0]->mode_of_payment;

        foreach ($getOrder as $order) {
            $total_cost += $order->quantity * $order->getProductRelation->price;
        }

        $payment = Payment::create([
            'order_number' => $getOrder[0]->order_number,
            'total_cost' => $total_cost,
            'shipping_fee' => $shipping_fee,
            'mode_of_payment' => $mode_of_payment,
            'status' => $request->paymentStatus,
        ]);

        $remittance = new Remittance;
        $remittance->payer_id = Auth::user()->id;
        $remittance->order_number = $getOrder[0]->order_number;
        $remittance->amount = $total_cost + $shipping_fee;
        $remittance->save();

        // Redirect Page
        return redirect('/orders/tracking')->with('success', 'Order Confirmed');
    }

    public function order_tracking()
    {
        $id = Auth::user()->id;
        $orders = Order::select('order_number', 'status', 'user_addresses_id', 'created_at', 'mode_of_payment')->where('user_id', '=', $id)->groupBy('order_number')->orderBy('created_at', 'desc')->get();

        $cart = Order::with('getProductRelation')->where([['user_id', '=', $id], ['user_addresses_id', '=', 'Pick Up']])->get();


        $data = ['orders' => $orders, 'cart' => $cart];

        return view('pages.customer.order_tracking.index')->with($data);
    }

    public function orderReceived(Request $request)
    {
        $order_number = $request->input('OrderNumber');
        $updateOrderStatus = Order::where([['order_number', '=', $order_number], ['status', '=', 'Order Arrived']])->update(['status' => 'Delivered']);

        return redirect()->back()->with('message', "Order Received");
    }

    public function orderFailedReceived(Request $request)
    {
        $order_number = $request->input('OrderNumber');
        $updateOrderStatus = Order::where([['order_number', '=', $order_number], ['status', '=', 'Order Arrived']])->update(['status' => 'Shipping']);

        return redirect()->back()->with('message', "Order not Received");
    }

    public function gcashPaymentSuccess()
    {
        // Retrieve the stored data from the session
        $orderDetails = session('order_details');
        $orderDetails['paymentStatus'] = 'Completed';

        // Call the function in this controller to handle order confirmation
        $response = $this->checkoutConfirm(Request::create('/orders/checkout/confirm', 'POST', $orderDetails));

        // Remove the data from the session
        session()->forget('order_details');

        return $response;
    }

    public function gcashPaymentFailed()
    {
        session()->forget('order_details');

        // Use the correct route name for the checkout route
        return redirect()->route('orders.checkout')->withErrors([
            'paymentFailed' => 'We apologize, but the online transaction with GCash has encountered an issue and cannot be completed at this time. Please double-check your GCash information and try again. If the problem persists, contact our support team for assistance.'
        ]);
    }
}
