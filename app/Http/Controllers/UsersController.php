<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function getList(Request $request)
    {
        $users = User::all()->where('id', '!=', auth()->user()->id);

        return view('users')->with('users', $users);
    }
}
