<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Auth;

class EmployeeController extends Controller
{
    public function index(){
        $employees = User::join('roles', 'users.id', '=', 'roles.user_id')
        ->where('user_id','!=', Auth::user()->id)
        ->whereIn('role', ['manager', 'cashier', 'courier', 'dismissed'])
        ->orderBy('role', 'desc')
        ->get();

        $data = [
            'employees' => $employees,
        ];
        return view('pages.owner.employees.index')->with($data);
    }

    public function show($id){
        $user = User::find($id);
        return view('pages.owner.employees.view')->with('user', $user);
    }

    public function update(Request $request, $id){
        $role = Role::where([['user_id', '=', $id]])->first();
        $role->role = $request->role;
        $role->save();
        return response()->json(['success'=>'Role Successfully Updated']);
    }
}
