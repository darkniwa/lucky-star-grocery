<?php

namespace App\Http\Controllers\Seller;

use App\Exports\RemittancesExport;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Remittance;
use App\Models\Transaction;
use App\Models\Wallet;
use Carbon\Carbon;
use Auth;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RemittanceController extends Controller
{
    public function index()
    {
        $collected_cash_today = number_format(Remittance::where('collector_id', Auth::user()->id)->whereDate('created_at', Carbon::today())->get()->sum('amount'), 2, '.', ',');
        $collected_cash_yesterday = number_format(Remittance::where('collector_id', Auth::user()->id)->whereDate('created_at', Carbon::yesterday())->get()->sum('amount'), 2, '.', ',');

        // Get Courier List
        $courierRole = Role::where('name', 'courier')->first();
        $courierUsers = User::role($courierRole)->get();

        $data = [
            "couriers" => $courierUsers,
            "collected_cash_today" => $collected_cash_today,
            "collected_cash_yesterday" => $collected_cash_yesterday,
        ];

        return view('pages.seller.remittance.index')->with($data);
    }

    public function collect(Request $request)
    {
        $remittances = Remittance::where('collector_id', $request->courier_id)->get();

        foreach ($remittances as $remittance) {
            $remittance->update([
                'remittance_handler_id' => Auth::user()->id,
                'status' => 'Remitted',
            ]);

            $transaction = new Transaction;
            $transaction->reference_no = $remittance->reference_no;
            $transaction->sender_id = $remittance->remittance_handler_id;
            $transaction->receiver_id = $remittance->collector_id;
            $transaction->type = 'Remit';
            $transaction->amount_received = $remittance->amount;
            $transaction->save();

            // Update the wallet for the collector
            $collectorWallet = Wallet::where('user_id', $remittance->collector_id)->first();

            if ($collectorWallet) {
                $collectorWallet->account_balance += $remittance->amount;
                $collectorWallet->save();
            } else {
                $newCollectorWallet = new Wallet();
                $newCollectorWallet->user_id = $remittance->collector_id;
                $newCollectorWallet->account_balance += $remittance->amount;
                $newCollectorWallet->save();
            }

            // Update the wallet for the remittance handler (current user)
            $remittanceHandlerWallet = Wallet::where('user_id', Auth::user()->id)->first();

            if ($remittanceHandlerWallet) {
                $remittanceHandlerWallet->account_balance += $remittance->amount;
                $remittanceHandlerWallet->save();
            } else {
                $newRemittanceHandlerWallet = new Wallet();
                $newRemittanceHandlerWallet->user_id = Auth::user()->id;
                $newRemittanceHandlerWallet->account_balance += $remittance->amount;
                $newRemittanceHandlerWallet->save();
            }
        }

        return response()->json([
            'success' => true,
        ]);
    }

    public function show($order_number)
    {
        $orders = Order::where([['order_number', '=', $order_number]])->with('getUserRelation', 'getCustomerRelation', 'getProductRelation')->get();
        $data = [
            'orders' => $orders,
            'order_number' => $order_number
        ];

        return view('pages.seller.remittance.show')->with($data);
    }

    public function report()
    {
        $remittances = Remittance::all()->sortByDesc('created_at');

        $data = [
            "remittances" => $remittances,
        ];

        return view('pages.seller.remittance.report')->with($data);
    }

    public function exportRemittance()
    {
        // Fetch all remittance
        $remittances = Remittance::all();

        // Export the data as CSV
        $export = new RemittancesExport($remittances);
        return $export->export();
    }
}
