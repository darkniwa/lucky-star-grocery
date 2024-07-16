<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Models\Activity;

class StaffManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('can:manage_staff');
    }

    public function index()
    {
        // Get the ID of the currently authenticated user
        $currentUserId = Auth::id();

        // Define an array of role names you want to filter by
        $roleNamesToFilter = ['manager', 'cashier', 'courier', 'promodiser'];

        // Retrieve users who have at least one of the specified roles and exclude the authenticated user
        $users = User::role($roleNamesToFilter)
            ->where('id', '!=', $currentUserId)
            ->get();

        // Pass the filtered staff members data to the staff.index view
        return view('pages.seller.staff.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.seller.staff.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile' => 'required|string|max:255|unique:users',
            'roles' => 'required|array',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'display_name' => $request->input('first_name') . ' ' . $request->input('last_name'),
            'mobile' => $request->input('mobile'),
            'password' => Hash::make($request->input('password')),
        ]);

        $user->assignRole($request->input('roles'));

        $newStaff = Staff::create([ // Change from Customer to Staff
            'user_id' => $user->id,
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
        ]);

        return redirect()->route('staff.create')->with('success', 'Staff member added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $staff = Staff::find($id);

        if (!$staff) {
            return response()->json(['error' => 'Staff not found'], 404);
        }

        // You can customize this view to display the staff details as you need
        return view('pages.seller.staff.details', compact('staff'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $staff = Staff::findOrFail($id);
        return view('pages.seller.staff.edit', compact('staff'));
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
        $staff = Staff::findOrFail($id);

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile' => 'required|string|max:255',
            'roles' => 'required|array',
            'password' => 'nullable|string|min:6',
        ]);

        $newFirstName = $request->input('first_name');
        $newLastName = $request->input('last_name');
        $newMobile = $request->input('mobile');
        $newRoles = $request->input('roles');
        $newPassword = $request->input('password');

        $changes = [];

        if ($staff->first_name !== $newFirstName) {
            $changes['first_name'] = [
                'old' => $staff->first_name,
                'new' => $newFirstName,
            ];
            $staff->first_name = $newFirstName;
        }

        if ($staff->last_name !== $newLastName) {
            $changes['last_name'] = [
                'old' => $staff->last_name,
                'new' => $newLastName,
            ];
            $staff->last_name = $newLastName;
        }

        // Update the related user's mobile number only if it has changed
        if ($staff->user->mobile !== $newMobile) {
            $changes['mobile'] = [
                'old' => $staff->user->mobile,
                'new' => $newMobile,
            ];
            $staff->user->mobile = $newMobile;
        }

        // Sync the roles only if they have changed
        if ($staff->user->getRoleNames()->toArray() !== $newRoles) {
            $changes['roles'] = [
                'old' => $staff->user->getRoleNames()->toArray(),
                'new' => $newRoles,
            ];
            $staff->user->syncRoles($newRoles);
        }

        // Update the password if provided and it's different from the current password
        if ($newPassword && !Hash::check($newPassword, $staff->user->password)) {
            $changes['password'] = [
                'old' => $staff->user->password,
                'new' => Hash::make($newPassword),
            ];
            $staff->user->password = Hash::make($newPassword);
        }

        // Save the changes to the staff member
        $staff->save();

        // Log the update action
        activity()
            ->performedOn($staff)
            ->causedBy(Auth::user())
            ->log('Updated staff member: ' . $staff->full_name);

        return redirect()->route('staff.index')->with('success', 'Staff member updated successfully.');
    }

    public function updateRoles(Request $request, $userId)
    {
        // Validate the request
        $request->validate([
            'roles' => 'required|array',
        ]);

        // Get the user by ID
        $user = User::findOrFail($userId);

        // Get the roles selected in the request
        $selectedRoles = $request->input('roles');

        // Get all roles from Spatie
        $allRoles = Role::all()->pluck('name')->toArray();

        // Sync the user's roles based on the selected roles
        $user->syncRoles(array_intersect($selectedRoles, $allRoles));

        // Fetch the updated user data, including roles
        $updatedUser = User::findOrFail($userId);

        // Return the updated roles as JSON
        return response()->json([
            'message' => 'Roles updated successfully',
            'updatedRoles' => $updatedUser->getRoleNames(),
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function rolesAndPermissions()
    {
        $roles = Role::whereIn('name', ['Manager', 'Cashier', 'Courier', 'Promodiser'])->get();
        $permissions = Permission::all();

        return view('pages.seller.staff.roles-permissions', compact('roles', 'permissions'));
    }

    public function assignPermissions(Request $request, Role $role)
    {
        $this->authorize('manage_staff');
        $permissions = $request->input('permissions', []);
        $role->syncPermissions($permissions);
        return back()->with('success', 'Permissions assigned to the role successfully');
    }

    public function removeStaff(Request $request, $userId)
    {
        // Get the user by their ID
        $user = User::find($userId);

        // Check if the user exists
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Define the roles you want to remove (excluding "customer")
        $rolesToRemove = ['admin', 'owner', 'manager', 'cashier', 'courier', 'promodiser'];

        // Filter the user's current roles to exclude the roles you want to remove
        $filteredRoles = $user->roles->filter(function ($role) use ($rolesToRemove) {
            return !in_array($role->name, $rolesToRemove);
        });

        // Sync the filtered roles to the user
        $user->syncRoles($filteredRoles);

        // Optionally, you can also delete the associated staff record
        $user->staff()->delete();

        return response()->json(['message' => 'Staff removed successfully']);
    }
}
