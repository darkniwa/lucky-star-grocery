<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\Delivery;
use App\Models\Order;
use Auth;

class WalletController extends Controller
{
    public function history(){
        $id = Auth::user()->id;
        $deliveries = Delivery::where('courier_id', '=', $id)->get();

        $data = ['deliveries' => $deliveries];
        return view('pages.seller.history.index')->with($data);
    }

    public function wallet(){
        $id = Auth::user()->id;
        $wallet = Wallet::firstOrCreate(["user_id" => $id]);
        $transactions = Transaction::where('receiver_id', $id)->get();

        $data = [
            "wallet" => $wallet,
            "transactions" => $transactions,
        ];

        return view('pages.seller.wallet.index')->with($data);
    }
}
