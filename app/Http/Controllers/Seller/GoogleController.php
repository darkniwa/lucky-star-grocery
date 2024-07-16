<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;

class GoogleController extends Controller
{

    protected function logGoogleLogin(User $user)
    {
        activity()
            ->performedOn($user)
            ->causedBy($user)
            ->log('Logged in via Google'); // Customize the log message as needed
    }

    // Seller Google Controller
    public function loginWithGoogle()
    {
        $redirectUrl = env('GOOGLE_REDIRECT_SELLER');
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirectUrl($redirectUrl)
            ->redirect();
    }

    public function callbackFromGoogle()
    {
        try {
            $user = Socialite::driver('google')->user();
    
            // Check if the user already exists by email
            $existingUser = User::where('email', $user->getEmail())->first();
    
            if (!$existingUser) {
                // User doesn't exist; handle accordingly, maybe show an error message.
                return redirect()->route('login')->with('error', 'User not found.');
            }
    
            // Check if the user has one of the specified roles
            $allowedRoles = ['owner', 'manager', 'cashier', 'courier', 'promodiser'];
    
            if (!$existingUser->hasAnyRole($allowedRoles)) {
                // User doesn't have the allowed roles; deny access.
                return redirect()->route('login')->with('error', 'Access denied.');
            }
    
            // Log in the user and redirect to the seller's dashboard.
            Auth::login($existingUser);
            $this->logGoogleLogin($existingUser);
            // Check if staff information exists for the user
            $staff = Staff::where('user_id', $existingUser->id)->first();

            if (!$staff) {
                // Staff information doesn't exist, so create it based on Google user details
                $staff = new Staff([
                    'user_id' => $existingUser->id,
                    'first_name' => $user->user['given_name'],
                    'last_name' => $user->user['family_name'],
                    'picture' => $user->user['picture'],
                ]);
                $staff->save();
            }

            return redirect()->route('index');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
}
