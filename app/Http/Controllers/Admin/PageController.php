<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class PageController extends Controller
{
    public function index(){
        $total_users = User::all()->count();
        $total_staff = User::join('roles', 'users.id', '=', 'roles.user_id')->where([['role','!=','customer'], ['role', '!=', 'ban']])->orderBy('role', 'desc')->count();
        $verified_users = (User::where('email_verified_at', '!=', null)->orWhere('mobile_verified_at', '!=', null)->count())/$total_users*100;
        $banned_users = User::join('roles', 'users.id', '=', 'roles.user_id')->where('role', 'ban')->orderBy('role', 'desc')->count();

        $data = [
            'total_users' => $total_users,
            'total_staff' => $total_staff,
            'verified_users' => number_format($verified_users, 0),
            'banned_users' => $banned_users,
        ];
        return view('pages.admin.index')->with($data);
    }
}
