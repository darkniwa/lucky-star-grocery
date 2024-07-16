<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Promotions;
use App\Models\User;

class PromotionController extends Controller
{
    public function index(){
        $email = User::select('email')->where('email', '!=', NULL)->get();
        return view('pages.seller.promotion.index')->with('email_address_list', $email);
    }

    public function sendEmail(Request $request){

        $emailList = $request->input('email_address');
        $message = $request->input('message');

        Mail::to($emailList)->send(new Promotions($message));
        
        return redirect(route('mail.promotions'));
    }
}
