<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Customer;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.customer.account');
    }

    public function address()
    {
        return view('pages.customer.address.index');
    }

    public function createAddress(){
        return view('pages.customer.address.add');
    }

    public function storeAddress(Request $request){
        // Validate the incoming request data
        $request->validate([
            'label' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
        ]);

        // Create a new address record
        $newAddress = UserAddress::create([
            'user_id' => Auth::user()->id,
            'label' => $request->input('label'),
            'street' => $request->input('street'),
            'barangay' => $request->input('barangay'),
            'city' => $request->input('city'),
            'province' => $request->input('province'),
            'postal_code' => $request->input('postal_code'),
        ]);

        $source = $request->input('source');
        if ($source === 'checkout') {
            return redirect()->route('orders.checkout')->with('success', 'Address added successfully.');
        } elseif ($source === 'address') {
            return redirect()->route('address')->with('success', 'Address added successfully.');
        }

        return dd($source);
        // Default fallback
            return redirect()->route('address.edit', $newAddress->id)->with('success', 'Address added successfully.');
            // return back()->with('success', 'Address added successfully.');
    }

    public function editAddress($id){
        $address = UserAddress::where([['id', $id], ['user_id', Auth::user()->id]])->first();
        return view('pages.customer.address.edit')->with('address', $address);
    }

    public function deleteAddress($id)
    {
        $address = UserAddress::where([['id', $id], ['user_id', Auth::user()->id]])->first();

        if ($address) {
            $address->delete();
            return redirect()->route('address')->with('success', 'Address deleted successfully.');
        }

        return back()->with('error', 'Address not found or you don\'t have permission to delete it.');
    }

    public function updateAddress(Request $request, $id){
        // Validate the incoming request data
        $request->validate([
            'label' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
        ]);

        // Find the address by ID
        $address = UserAddress::findOrFail($id);

        // Update the address data
        $address->update([
            'label' => $request->input('label'),
            'street' => $request->input('street'),
            'barangay' => $request->input('barangay'),
            'city' => $request->input('city'),
            'province' => $request->input('province'),
            'postal_code' => $request->input('postal_code'),
        ]);

        return redirect()->route('address')->with('success', 'Address updated successfully.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
     public function update(Request $request)
    {
        $user = Auth::user();
        $customer = $user->getCustomerRelation;

        if ($request->form == "form-profile") {
            // Validation rules
            $rules = [
                'first_name' => 'required_if:first_name,' . $customer->first_name,
                'last_name' => 'required_if:last_name,' . $customer->last_name,
                'mobile' => [
                    'required_if:mobile,' . $user->mobile,
                    'numeric',
                    Rule::unique('users')->where(function ($query) {
                        return $query->whereNotNull('mobile_verified_at');
                    })->ignore($user->id),
                    'digits:11', // Ensure the mobile number has exactly 11 digits
                    'starts_with:09', // Ensure the mobile number starts with "09"
                ],
                'email' => 'email|unique:users,email,' . $user->id,
            ];
            $this->validate($request, $rules);

            // Update user and customer
            $user->email = $request->email ?? $user->email;
            $user->mobile = $request->mobile ?? $user->mobile;
            $user->save();

            $customer->first_name = $request->first_name ?? $customer->first_name;
            $customer->middle_name = $request->middle_name;
            $customer->last_name = $request->last_name ?? $customer->last_name;
            $customer->save();

        } elseif ($request->form == "form-password") {
            $this->validate($request, [
                'current_password' => ['required', new MatchOldPassword],
                'new_password' => 'required',
            ]);

            $user->update(['password' => Hash::make($request->new_password)]);
        }

        if ($request->form == "form-address") {
            return redirect()->route('address');
        }
        return redirect('/account');
    }

    
}
