<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use Auth;

class AccountController extends Controller
{
    public function index(){
        return view('pages.admin.account.index');
    }

    public function update(Request $request){
        // Form Validation
        $this->validate($request, [
            'FirstName' => 'required',
            'LastName' => 'required',
            'Gender' => 'required',
        ]);

        $user = User::find(Auth::user()->id);
        $customer = Customer::where('user_id', '=', Auth::user()->id)->first();
        
        $user->display_name = $request->input('FirstName').' '.$request->input('LastName');

        if ($user->mobile != $request->input('mobile')) {
            $this->validate($request, ['mobile' => ['string', 'min:10', 'max:10', 'unique:users', 'nullable']]);
            $user->mobile = $request->input('mobile') !== NULL ? $request->input('mobile') : '';
        }
        
        $customer->first_name = $request->input('FirstName');
        $customer->last_name = $request->input('LastName');
        $customer->gender = $request->input('Gender');

        $user->save();
        $customer->save();
        
        
        return redirect()->back();

    }
}
