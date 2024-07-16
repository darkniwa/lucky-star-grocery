<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use App\Models\Staff;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'mobile';
    }

    /**
     * Log the login attempt.
     *
     * @param Request $request
     * @return void
     */
    protected function logLogin(Request $request)
    {
        activity()
            ->performedOn(Auth::user())
            ->causedBy(Auth::user())
            ->log('User logged in from ' . $request->ip()); // Customize the log message as needed
    }

    public function showLoginForm()
    {
        $subdomain = explode('.', request()->getHost())[0];

        if ($subdomain === 'seller') {
            return view('pages.seller.auth.login'); // Show the seller login view
        }

        return view('auth.login'); // Show the customer login view
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'mobile' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['mobile' => $request->mobile, 'password' => $request->password])) {
            $user = Auth::user();
            $subdomain = explode('.', request()->getHost())[0]; // Get the subdomain

            // Check the subdomain to determine the role-based access
            if ($subdomain === 'seller') {
                // Check if the user has one of the seller roles
                $sellerRoles = ['owner', 'manager', 'cashier', 'courier', 'promodiser'];
                if ($user->hasAnyRole($sellerRoles)) {
                    // User has one of the seller roles, proceed with login
                    $this->logLogin($request);

                    // Check if staff information exists for the user
                    $staff = Staff::where('user_id', $user->id)->first();

                    if (!$staff) {
                        // Split the display_name into first_name and last_name
                        $displayName = $user->display_name; // Assuming 'display_name' is the field containing the full name
                        list($firstName, $lastName) = explode(' ', $displayName, 2);

                        // Create staff information based on user details
                        $staff = new Staff([
                            'user_id' => $user->id,
                            'first_name' => $firstName,
                            'last_name' => $lastName,
                            'picture' => $user->picture,
                        ]);
                        $staff->save();
                    }

                    return redirect()->intended($this->redirectPath());
                }
            } elseif ($subdomain === 'www') {
                // Check if the user has the 'customer' role
                if ($user->hasRole('customer')) {
                    // User has the 'customer' role, proceed with login
                    return redirect()->intended($this->redirectPath());
                }
            }

            // User does not have the required role or subdomain, log them out
            Auth::logout();
            return redirect()->route('login')->with('error', 'Access denied. Incorrect Mobile or Password');
        }

        return back()->withInput($request->only('mobile'));
    }
}
