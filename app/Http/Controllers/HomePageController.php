<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\PublicPost;

class HomePageController extends Controller
{
    public function index(){

        $posts = PublicPost::select('public_posts.*', 'users.name as user_name')
            ->join('users', 'users.id', '=', 'public_posts.user')
            ->latest()->paginate();

        return view('dashboard', ['posts' => $posts]);
    }







}
