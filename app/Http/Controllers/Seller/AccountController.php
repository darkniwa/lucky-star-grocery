<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Staff;
use Spatie\Activitylog\Traits\LogsActivity;
use Auth;

class AccountController extends Controller
{
    
    protected function logUpdateAction($actionName, User $user, Staff $staff, array $changes)
    {
        // Initialize the log message
        $logMessage = "Updated $actionName";

        // Combine the changes into a single log message
        $logMessage .= ' with the following changes:';

        activity()
            ->performedOn($user)
            ->causedBy(Auth::user())
            ->withProperties(['attributes' => $changes]) // Log the changes as properties
            ->log($logMessage);
    }

    public function profile(){
        return view('pages.seller.account.profile');
    }

    public function settings(){
        return view('pages.seller.account.settings');
    }

    public function management(){
        return view('pages.seller.account.management');
    }

    public function update(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $staff = Staff::where('user_id', '=', Auth::user()->id)->first();
        $formType = $request->input('form_type');
        $changes = []; // Initialize an array to track changes

        if ($formType === 'basic_information') {
            // Update basic information
            $userDisplayName = $user->display_name;
            $userMobile = $user->mobile;

            $user->display_name = $request->input('FirstName').' '.$request->input('LastName');
            
            if ($userMobile != $request->input('mobile')) {
                $this->validate($request, ['mobile' => ['string', 'min:13', 'max:13', 'unique:users', 'nullable']]);
                $user->mobile = $request->input('mobile') !== null ? $request->input('mobile') : '';
                $changes['mobile'] = ['old' => $userMobile, 'new' => $user->mobile];
            }

            $staffFirstName = $staff->first_name;
            $staffLastName = $staff->last_name;

            $staff->first_name = $request->input('FirstName');
            $staff->last_name = $request->input('LastName');

            // Check if there are changes in staff's first and last name
            if ($staffFirstName != $request->input('FirstName') || $staffLastName != $request->input('LastName')) {
                $changes['staff_name'] = [
                    'old' => "$staffFirstName $staffLastName",
                    'new' => "{$staff->first_name} {$staff->last_name}",
                ];
            }

            $user->save();
            $staff->save();
        } elseif ($formType === 'additional_information') {
            // Update additional information
            $staffGender = $staff->gender;
            $staff->gender = $request->input('Gender');

            if ($staffGender != $request->input('Gender')) {
                $changes['gender'] = ['old' => $staffGender, 'new' => $staff->gender];
            }

            $staff->save();
        }

        // Call the logUpdateAction method to log the changes
        $this->logUpdateAction('basic information', $user, $staff, $changes);

        return redirect(route('account.profile'));
    }

}

