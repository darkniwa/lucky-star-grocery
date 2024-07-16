<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Auth;

class UserManagementController extends Controller
{
    public function index(){
        $staff = User::join('roles', 'users.id', '=', 'roles.user_id')
        ->where([['user_id','!=', Auth::user()->id], ['role', '!=', 'admin']])
        ->whereIn('role', ['owner', 'manager', 'cashier', 'courier', 'dismissed'])
        ->orderBy('role', 'desc')
        ->get();
        
        $customer = User::join('roles', 'users.id', '=', 'roles.user_id')
        ->whereIn('role', ['customer', 'ban'])
        ->orderBy('role', 'desc')
        ->get();

      

        $users = $staff->merge($customer);

        $data = [
            'users' => $users,
        ];
        return view('pages.admin.user_management.index')->with($data);
    }

    public function show($id){
        $user = User::find($id);
        return view('pages.admin.user_management.view')->with('user', $user);
    }

    public function update(Request $request, $id){
        $role = Role::where([['user_id', '=', $id]])->first();
        $role->role = $request->role;
        $role->save();
        return response()->json(['success'=>'Role Successfully Updated']);
    }
}
