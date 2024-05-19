<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request, $user_id){
        $user = User::find($user_id);

        return view('global.user-profile', ['user'=> $user]);
    }


    




}
