<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\PublicPost;

class UserController extends Controller
{
    public function index(Request $request, $user_id){
        $user = User::find($user_id);
        $posts = PublicPost::where('user', $user->id)->latest()->paginate();
        
        return view('global.user-profile', ['user'=> $user, "posts" => $posts]);
    }


    




}
